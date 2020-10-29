<?php

class UserData {
    public $name, $phone, $email;
    public function checkData()
    {
        if ($this->name != '' && $this->phone != '' && $this->email != '' && strlen($this->phone) >= 11 && ((stristr($this->email, '.') == '.com' || stristr($this->email, '.') == '.org')))
        {
            $this->returnSuccess();
            $this->saveData($this->name, $this->phone, $this->email);
        }
        else
        {
            $this->returnError();
        }
    }

    public function saveData($name, $phone, $email)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        setcookie('user_name', $this->name);
        setcookie('user_phone', $this->phone);
        setcookie('user_email', $this->email);
    }

    public function returnError()
    {
        if ($this->name == ''){
            setcookie('error_name', '<p style="color: red; font-size: 12px">Поле обязательно к заполнению</p>');
        }
        else
        {
            setcookie('error_name', '');
        }

        if ($this->phone == ''){
            setcookie('error_phone', '<p style="color: red; font-size: 12px">Поле обязательно к заполнению</p>');
        }
        else if (strlen($this->phone) < 11)
        {
            setcookie('error_phone', '<p style="color: red; font-size: 12px">Телефон слишком короткий</p>');
        }
        else
        {
            setcookie('error_phone', '');
        }

        if ($this->email == ''){
            setcookie('error_email', '<p style="color: red; font-size: 12px">Поле обязательно к заполнению</p>');
        }
        else if (stristr($this->email, '.') != '.com' && stristr($this->email, '.') != '.org')
        {
            setcookie('error_email', '<p style="color: red; font-size: 12px">Допускается указывать почту в доменах *.com и *.org</p>');
        }
        else
        {
            setcookie('error_email', '');
        }

        header('location: /index.php?user_name=' . $this->name . '&user_phone=' . $this->phone . '&user_email=' . $this->email);
    }

    public function returnSuccess()
    {
        header('location: /thanks.php?user_name=' . $this->name . '&user_phone=' . $this->phone . '&user_email=' . $this->email);
    }
}

$user = new UserData();
$user->name = $_POST['user_name'];
$user->phone = preg_replace('/[^0-9+]/', '', $_POST['user_phone']) ;
$user->email = $_POST['user_email'];
$user->checkData();