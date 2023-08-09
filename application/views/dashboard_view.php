<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $user->name; ?></h1>
    <p>Email: <?php echo $user->email; ?></p>
    <img src="<?php echo $user->profile_picture; ?>" alt="Profile Picture">
</body>
</html>
