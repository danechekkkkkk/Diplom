<?php
require_once 'vendor/connect.php';
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT name_organization, address, director, accountant, taxpayer_number, ogrn, account FROM personal_data WHERE user_id = \$1";
$result = pg_query_params($connect, $query, array($user_id));

if ($result) {
    $data = pg_fetch_assoc($result); 
} else {
    echo "Ошибка при извлечении данных: " . pg_last_error($connect);
    $data = []; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/lk.css"> 
    <title>Личный кабинет</title>
</head>
<body>
    <div class="header">
        <div class="header-line">
            <div class="logo">
                <img src="images/logo.svg" alt="Логотип">
            </div>
            <div class="menu">
                <a class="menu-item" href="warehouse.php">Склад</a>
                <a class="menu-item" href="procurement.php">Закупки</a>
                <a class="menu-item" href="sales.php">Статистика</a>
            </div>
            <div class="lk">
                <a class="menu-item" href="lk.php">Личный кабинет</a>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="line-text">
        <p>Личный кабинет</p>
    </div>
    <div class="cont">
        <div class="form-container">
            <form action="vendor/lk/save_data_lk.php" method="post"> 
                <div class="main-container">
                    <div class="left-column">
                        <div class="form-group">
                            <label for="organization">Имя организации:</label>
                            <input class="in-lk" type="text" id="organization" name="organization" value="<?php echo isset($_SESSION['organization']) ? htmlspecialchars($_SESSION['organization']) : ''; ?>">
                        </div>
    
                        <div class="form-group">
                            <label for="address">Юр. адрес:</label>
                            <input class="in-lk" type="text" id="address" name="address" value="<?php echo isset($data['address']) ? htmlspecialchars($data['address']) : ''; ?>">
                        </div>
    
                        <div class="form-group">
                            <label for="director">Ген. директор:</label>
                            <input class="in-lk" type="text" id="director" name="director" value="<?php echo isset($data['director']) ? htmlspecialchars($data['director']) : ''; ?>">
                        </div>
    
                        <div class="form-group">
                            <label for="accountant">Глав. бухгалтер:</label>
                            <input class="in-lk" type="text" id="accountant" name="accountant" value="<?php echo isset($data['accountant']) ? htmlspecialchars($data['accountant']) : ''; ?>">
                        </div>
    
                        <button class="btn-lk" type="submit">Сохранить</button>
                    </div>
    
                    <div class="right-column">
                        <div class="form-group">
                            <label for="ogrn">ОГРН:</label>
                            <input class="in-lk" type="text" id="ogrn" name="ogrn" value="<?php echo isset($data['ogrn']) ? htmlspecialchars($data['ogrn']) : ''; ?>">
                        </div>
    
                        <div class="form-group">
                            <label for="inn">ИНН:</label>
                            <input class="in-lk" type="text" id="inn" name="inn" value="<?php echo isset($_SESSION['inn']) ? htmlspecialchars($_SESSION['inn']) : ''; ?>">
                        </div>
    
                        <div class="form-group">
                            <label for="account">Р/Сч:</label>
                            <input class="in-lk" type="text" id="account" name="account" value="<?php echo isset($data['account']) ? htmlspecialchars($data['account']) : ''; ?>">
                        </div>
    
                    
                    </div>
                </div>
            </form>
            <form action="vendor/lk/logout.php" method = "post">
                <button type = "submit" class = "logout-btn">Выйти</button>
            </form>
        </div>
    </div>
</div>
<?php if (isset($_SESSION['save_success']) && $_SESSION['save_success']): ?>
    <div id="successModal" class="modal">
        <div class="modal-content">
            <p>Данные успешно сохранены!</p>
            <button id="closeModalBtn">ОК</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('successModal');
            const closeBtn = document.getElementById('closeModalBtn');

            modal.style.display = 'block';

            closeBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });
        });
    </script>
    <?php unset($_SESSION['save_success']); ?>
<?php endif; ?>

</body>
</html>
