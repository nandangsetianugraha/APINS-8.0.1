<?php
session_start();
if (!isset($_SESSION['peserta_didik_id'])) {
    header("location:login/");
}else{
	header("location:beranda");
};
?>