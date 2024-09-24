<?php
$file = 'data.txt'; // Файл для хранения данных

// Сохранение данных
if (isset($_POST['save'])) {
    $name = trim($_POST['name']);
    $birthdate = trim($_POST['birthdate']);
    $data = "$name,$birthdate\n"; // Формат: имя, дата рождения
    file_put_contents($file, $data, FILE_APPEND);
    echo "Данные сохранены.";
}

// Поиск данных
if (isset($_POST['search_button'])) {
    $search = trim($_POST['search']);
    $found = false;

    if (file_exists($file)) {
        $lines = file($file);
        foreach ($lines as $line) {
            list($name, $birthdate) = explode(',', trim($line));
            if (stripos($name, $search) !== false) {
                echo "Найдена запись: $name, $birthdate<br>";
                $found = true;
            }
        }
    }

    if (!$found) {
        echo "Запись не найдена.";
    }
}

// Удаление данных
if (isset($_POST['delete_button'])) {
    $delete = trim($_POST['delete']);
    $lines = file($file);
    $new_lines = [];

    foreach ($lines as $line) {
        list($name, $birthdate) = explode(',', trim($line));
        if (stripos($name, $delete) !== false) {
            echo "Запись удалена: $name, $birthdate<br>";
        } else {
            $new_lines[] = $line; // Сохраняем записи, которые не нужно удалять
        }
    }

    file_put_contents($file, $new_lines);
}

// Проверка дней рождения
if (isset($_POST['birthday_check'])) {
    $today = date('Y-m-d');
    $found = false;

    if (file_exists($file)) {
        $lines = file($file);
        foreach ($lines as $line) {
            list($name, $birthdate) = explode(',', trim($line));
            if ($birthdate === $today) {
                echo "У сегодня день рождения: $name<br>";
                $found = true;
            }
        }
    }

    if (!$found) {
        echo "На сегодня нет дней рождения.";
    }
}


