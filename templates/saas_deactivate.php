<?php

function Get($index, $defaultValue) {
    return isset($_GET[$index]) ? $_GET[$index] : $defaultValue;
}

function is_run_from_cli() {
    if( defined('STDIN') )
    {
        return true;
    }
    return false;
}

if (!is_run_from_cli()) {
    # check SaasActivationPassword
    if (Get('SaasActivationPassword', 'invalid') != '{{SaasActivationPassword}}') {
        echo '{"success": false, "msg": "invalid SaasActivationPassword"}';
        exit(1);
    }
}

try {
    $pdo = new PDO('pgsql:host=localhost;dbname={{pac}}_{{user}}', '{{pac}}_{{user}}', '{{password}}');
    # lock all users permanently
    $stmt = $pdo->query("SELECT login from users");
    while ($row = $stmt->fetch()) {
        # deactivate the user
        $stmtUpdate = $pdo->prepare("UPDATE users SET status=3 WHERE login=? AND status=1");
        $stmtUpdate->execute([$row['login']]);
    }
}
catch (Exception $e) {
    // echo 'Exception caught: ',  $e->getMessage(), "\n";
    echo '{"success": false, "msg": "error happened"}';
    exit(1);
}

echo '{"success": true}';

?>