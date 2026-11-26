<?php
session_start();
require_once 'db.php';

// Block access if not logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// ============================================================
// CREATE CONSIGNMENT
// ============================================================
$create_msg = '';
if (isset($_POST['create'])) {
    $tracking  = strtoupper(trim($_POST['tracking_number']));
    $sender    = trim($_POST['sender_name']);
    $receiver  = trim($_POST['receiver_name']);
    $origin    = trim($_POST['origin']);
    $dest      = trim($_POST['destination']);
    $weight    = trim($_POST['weight']);
    $eta       = trim($_POST['eta']);

    if ($tracking && $sender && $receiver) {
        $stmt = $conn->prepare("INSERT INTO consignments (tracking_number, sender_name, receiver_name, origin, destination, weight, estimated_delivery) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $tracking, $sender, $receiver, $origin, $dest, $weight, $eta);
        if ($stmt->execute()) {
            $create_msg = "✅ Consignment <strong>$tracking</strong> created successfully!";
        } else {
            $create_msg = "❌ Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $create_msg = "❌ Please fill in Tracking Number, Sender, and Receiver.";
    }
}

// ============================================================
// ADD STATUS UPDATE
// ============================================================
$update_msg = '';
if (isset($_POST['add_update'])) {
    $tracking   = strtoupper(trim($_POST['update_tracking']));
    $new_status = trim($_POST['new_status']);
    $new_loc    = trim($_POST['new_location']);
    $new_text   = trim($_POST['new_text']);

    if ($tracking && $new_status && $new_text) {
        $check = $conn->prepare("SELECT id FROM consignments WHERE tracking_number = ?");
        $check->bind_param("s", $tracking);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $up1 = $conn->prepare("UPDATE consignments SET status = ? WHERE tracking_number = ?");
            $up1->bind_param("ss", $new_status, $tracking);
            $up1->execute();
            $up1->close();

            $up2 = $conn->prepare("INSERT INTO consignment_updates (tracking_number, status_text, location) VALUES (?, ?, ?)");
            $up2->bind_param("sss", $tracking, $new_text, $new_loc);
            $up2->execute();
            $up2->close();

            $update_msg = "✅ Update added for <strong>$tracking</strong> → $new_status";
        } else {
            $update_msg = "❌ Tracking number not found.";
        }
        $check->close();
    } else {
        $update_msg = "❌ Please fill all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Kariez</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root { --primary: #FFCC00; --dark: #0a0a0a; }
        body { font-family: 'DM Sans', sans-serif; background: #f4f6f9; margin: 0; color: #333; }
        h1, h2 { font-family: 'Outfit', sans-serif; }

        /* PRELOADER */
        #preloader { position: fixed; inset: 0; background: #fff; display: flex; align-items: center; justify-content: center; z-index: 999999; transition: opacity .35s ease, visibility .35s ease; }
        #preloader.loaded { opacity: 0; visibility: hidden; }

        .dash-header {
            background: var(--dark); color: #fff; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .dash-header h1 { font-size: 20px; margin: 0; }
        .dash-header a { color: var(--primary); text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .dash-header a:hover { color: #fff; }

        .dash-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        @media(max-width: 900px) { .dash-container { grid-template-columns: 1fr; } }

        .card { background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .card h2 { font-size: 20px; margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid var(--primary); padding-bottom: 10px; }
        .card label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #555; }
        .card input, .card select, .card textarea {
            width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;
            font-size: 14px; box-sizing: border-box; margin-bottom: 16px; font-family: 'DM Sans', sans-serif;
        }
        .card input:focus, .card select:focus, .card textarea:focus { outline: none; border-color: var(--primary); }
        .card button {
            width: 100%; padding: 12px; background: var(--primary); border: none;
            border-radius: 6px; font-weight: 700; cursor: pointer; transition: 0.3s;
            font-family: 'DM Sans', sans-serif; color: #000;
        }
        .card button:hover { background: #000; color: var(--primary); }

        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d1e7dd; color: #0f5132; border-left: 4px solid #0f5132; }
        .alert-error { background: #ffe0e0; color: #b00020; border-left: 4px solid #b00020; }

        .preview-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
        .preview-table th, .preview-table td { padding: 8px 10px; border-bottom: 1px solid #eee; text-align: left; }
        .preview-table th { background: #f9f9f9; font-weight: 700; }
    </style>
</head>
<body>

<div id="preloader"><img width="200" height="200" src="https://thunderboltcarriers.com/wp-content/uploads/2024/12/preloader.gif" alt="Loading..."></div>

<div class="dash-header">
    <h1><i class="fa-solid fa-truck-fast" style="color: var(--primary);"></i> Kariez Admin Dashboard</h1>
    <a href="dashboard.php?logout=1"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="dash-container">

    <!-- CREATE CONSIGNMENT -->
    <div class="card">
        <h2><i class="fa-solid fa-plus-circle" style="color: var(--primary);"></i> Create Consignment</h2>

        <?php if (!empty($create_msg)): ?>
            <div class="alert <?= strpos($create_msg, '✅') !== false ? 'alert-success' : 'alert-error' ?>">
                <?= $create_msg ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Tracking Number (e.g. TRK-8921-A)</label>
            <input type="text" name="tracking_number" required placeholder="TRK-XXXX-X">

            <label>Sender Name</label>
            <input type="text" name="sender_name" required placeholder="John Doe">

            <label>Receiver Name</label>
            <input type="text" name="receiver_name" required placeholder="Jane Smith">

            <label>Origin</label>
            <input type="text" name="origin" placeholder="Douala, Cameroon">

            <label>Destination</label>
            <input type="text" name="destination" placeholder="Paris, France">

            <label>Weight</label>
            <input type="text" name="weight" placeholder="12 kg">

            <label>Estimated Delivery</label>
            <input type="date" name="eta">

            <button type="submit" name="create"><i class="fa-solid fa-floppy-disk"></i> Create Consignment</button>
        </form>
    </div>

    <!-- ADD STATUS UPDATE -->
    <div class="card">
        <h2><i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i> Add Status Update</h2>

        <?php if (!empty($update_msg)): ?>
            <div class="alert <?= strpos($update_msg, '✅') !== false ? 'alert-success' : 'alert-error' ?>">
                <?= $update_msg ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Tracking Number</label>
            <input type="text" name="update_tracking" required placeholder="TRK-8921-A">

            <label>New Main Status</label>
            <select name="new_status">
                <option value="Pending">Pending</option>
                <option value="In Transit">In Transit</option>
                <option value="Out for Delivery">Out for Delivery</option>
                <option value="Delivered">Delivered</option>
            </select>

            <label>Event Description</label>
            <input type="text" name="new_text" required placeholder="Arrived at sorting facility">

            <label>Location</label>
            <input type="text" name="new_location" placeholder="Douala, Cameroon">

            <button type="submit" name="add_update"><i class="fa-solid fa-circle-check"></i> Add Update</button>
        </form>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

        <h2 style="font-size: 16px; border: none; padding: 0; margin-bottom: 15px;">
            <i class="fa-solid fa-list" style="color: var(--primary);"></i> Recent Consignments
        </h2>
        <?php $recent = $conn->query("SELECT tracking_number, status FROM consignments ORDER BY id DESC LIMIT 5"); ?>
        <table class="preview-table">
            <tr><th>Tracking #</th><th>Status</th></tr>
            <?php while ($r = $recent->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['tracking_number']) ?></td>
                    <td><?= htmlspecialchars($r['status']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

<script>
window.addEventListener('load', function(){
    var p = document.getElementById('preloader');
    if (p) setTimeout(function(){ p.classList.add('loaded'); }, 300);
});
</script>

</body>
</html>