<?php

function drawProfilePage(User $user) { ?>
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/notification.css">
    <main class="profile-page">
        <div class="left-side">
            <div class="profile-details">
                <h1>Hello <?php echo $user->name;?></h1>
                <a href="../actions/action_logout.php"><p>Close session</p></a>
            </div>
            <div class="account-panel">
                <h2>Account Panel</h2>
                <button onclick="updateRightSide('personalData')">Personal data</button>
                <?php if ($user->isAdmin) { ?>
                    <button> <a href="../pages/adminPage.php">Admin Privileges</a></button>
                <?php } ?>
                <button onclick="updateRightSide('myOrders')">My Orders</button>
                <button onclick="updateRightSide('mySales')">My Sales</button>
                <script src="../javascript/profile.js"></script>
            </div>
            <div class="need-help">
                <h2>Need Help</h2>
                <h3>Contact us:</h3>
                <p>test@gmail.com</p>
                <p>960000000</p>
            </div>
        </div>

        <div class="right-side" id="right-side">
            <h1>Personal Data</h1>
            <div class="personal-data">
                
            </div>
        </div>
    </main>
<?php
}
?>