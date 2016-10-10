<?php
// Подключаемся к БД
$conn = mysqli_connect("localhost", "mysql", "mysql", "myDB");


//Читаем файл
$handle = @fopen("error (1).log", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        parseAndAddToDB($buffer, $conn);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

mysqli_close($conn);

function parseAndAddToDB($log_str, $conn)
{

    //Разбиваем строку
    $log_str = addslashes($log_str);
    $log_arr = preg_split("/\]\s|referer:\s/", $log_str);
    $log_arr = preg_replace("/\[|pid\s|client\s/", "", $log_arr);
    $log_arr_lgth = count($log_arr);
    
    //Записываем данные в БД
    if ($log_arr_lgth == 5) {
        $conn->query("INSERT INTO log_table (log_date, log_type, log_pid, log_ip, log_description)
            VALUES ('$log_arr[0]', '$log_arr[1]', '$log_arr[2]', '$log_arr[3]', '$log_arr[4]')");
    }
    elseif ($log_arr_lgth == 6) {
        $conn->query("INSERT INTO log_table (log_date, log_type, log_pid, log_ip, log_description, log_referer)
            VALUES ('$log_arr[0]', '$log_arr[1]', '$log_arr[2]', '$log_arr[3]', '$log_arr[4]', '$log_arr[5]')");
    }
    else{
        $conn->query("INSERT INTO log_table (log_date, log_type, log_pid, log_description)
            VALUES ('$log_arr[0]', '$log_arr[1]', '$log_arr[2]', '$log_arr[3]')");
    }
}
?>
