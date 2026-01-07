<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
</head>

<body>
    <h1>Dashboard</h1>
    <p>Welcome,
        <?= $_SESSION['username'] ?>!
    </p>
    <p><em>(Waiting for UI Design Screenshots to implement the real layout)</em></p>

    <a href="/Ecom-CMS/auth/logout">Logout</a>
</body>

</html>