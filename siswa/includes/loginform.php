<?php
date_default_timezone_set('Asia/Jakarta');
class LoginForm extends DbConn
{
    public function checkLogin($myusername, $mypassword)
    {
        $conf = new GlobalConf;
        $ip_address = $conf->ip_address;
        $login_timeout = $conf->login_timeout;
        $max_attempts = $conf->max_attempts;
        $timeout_minutes = $conf->timeout_minutes;
        $attcheck = checkAttempts($myusername);
        $curr_attempts = $attcheck['attempts'];

        $datetimeNow = date("Y-m-d H:i:s");
        $oldTime = strtotime($attcheck['lastlogin']);
        $newTime = strtotime($datetimeNow);
        $timeDiff = $newTime - $oldTime;

        try {

            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        $stmt = $db->conn->prepare("SELECT * FROM siswa WHERE nisn = :myusername");
        $stmt->bindParam(':myusername', $myusername);
        $stmt->execute();

        // Gets query result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
		$hasil = $stmt->fetch(PDO::rowCount());
        if ($hasil>0) {

             //If max attempts not exceeded, continue
            // Checks password entered against db password hash
			$ftgl=$result['tanggal'];
			$tgl=explode("-",$ftgl);
			$passw=$tgl[0].$tgl[1].$tgl[2];
            if ($mypassword==$passw) {

                //Success! Register $myusername, $mypassword and return "true"
                $success = 'true';
                session_start();
				$_SESSION['userpd'] = $myusername;
                $_SESSION['password'] = $mypassword;
				$_SESSION['userid'] = $result['peserta_didik_id'];
			} else {

                //Wrong username or password
				$success = '
				<div class="empty-state" data-height="100"><div class="empty-state-icon bg-danger"><i class="fas fa-check"></i></div><h2>Login Gagal</h2><p class="lead">Username atau Password tidak ditemukan!</p><a href="./" class="btn btn-warning mt-4">Coba Lagi</a></div>
				';

            }
        
        } else {

            $stmt1 = $db->conn->prepare("SELECT * FROM siswa WHERE nis = :myusername");
			$stmt1->bindParam(':myusername', $myusername);
			$stmt1->execute();

			// Gets query result
			$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$hasil1 = $stmt1->fetch(PDO::rowCount());
			if ($hasil1>0) {

				 //If max attempts not exceeded, continue
				// Checks password entered against db password hash
				$ftgl=$result['tanggal'];
				$tgl=explode("-",$ftgl);
				$passw=$tgl[0].$tgl[1].$tgl[2];
				if ($mypassword==$passw) {

					//Success! Register $myusername, $mypassword and return "true"
					$success = 'true';
					session_start();
					$_SESSION['userpd'] = $myusername;
					$_SESSION['password'] = $mypassword;
					$_SESSION['userid'] = $result['peserta_didik_id'];
				} else {

					//Wrong username or password
					$success = '
					<div class="empty-state" data-height="100"><div class="empty-state-icon bg-danger"><i class="fas fa-check"></i></div><h2>Login Gagal</h2><p class="lead">Username atau Password tidak ditemukan!</p><a href="./" class="btn btn-warning mt-4">Coba Lagi</a></div>
					';

				}
			
			} else {
				$success = '
					<div class="empty-state" data-height="100"><div class="empty-state-icon bg-danger"><i class="fas fa-check"></i></div><h2>Login Gagal</h2><p class="lead">Username atau Password tidak ditemukan!</p><a href="./" class="btn btn-warning mt-4">Coba Lagi</a></div>
					';
			};
        }
        return $success;
    }

    public function insertAttempt($username)
    {
        try {
            $db = new DbConn;
            $conf = new GlobalConf;
            $tbl_attempts = $db->tbl_attempts;
            $ip_address = $conf->ip_address;
            $login_timeout = $conf->login_timeout;
            $max_attempts = $conf->max_attempts;

            $datetimeNow = date("Y-m-d H:i:s");
            $attcheck = checkAttempts($username);
            $curr_attempts = $attcheck['attempts'];

            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_attempts." (ip, attempts, lastlogin, username) values(:ip, 1, :lastlogin, :username)");
            $stmt->bindParam(':ip', $ip_address);
            $stmt->bindParam(':lastlogin', $datetimeNow);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $curr_attempts++;
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        //Determines returned value ('true' or error code)
        $resp = ($err == '') ? 'true' : $err;

        return $resp;

    }

    public function updateAttempts($username)
    {
        try {
            $db = new DbConn;
            $conf = new GlobalConf;
            $tbl_attempts = $db->tbl_attempts;
            $ip_address = $conf->ip_address;
            $login_timeout = $conf->login_timeout;
            $max_attempts = $conf->max_attempts;
            $timeout_minutes = $conf->timeout_minutes;

            $att = new LoginForm;
            $attcheck = checkAttempts($username);
            $curr_attempts = $attcheck['attempts'];

            $datetimeNow = date("Y-m-d H:i:s");
            $oldTime = strtotime($attcheck['lastlogin']);
            $newTime = strtotime($datetimeNow);
            $timeDiff = $newTime - $oldTime;

            $err = '';
            $sql = '';

            if ($curr_attempts >= $max_attempts && $timeDiff < $login_timeout) {

                if ($timeDiff >= $login_timeout) {

                    $sql = "UPDATE ".$tbl_attempts." SET attempts = :attempts, lastlogin = :lastlogin where ip = :ip and username = :username";
                    $curr_attempts = 1;

                }

            } else {

                if ($timeDiff < $login_timeout) {

                    $sql = "UPDATE ".$tbl_attempts." SET attempts = :attempts, lastlogin = :lastlogin where ip = :ip and username = :username";
                    $curr_attempts++;

                } elseif ($timeDiff >= $login_timeout) {

                    $sql = "UPDATE ".$tbl_attempts." SET attempts = :attempts, lastlogin = :lastlogin where ip = :ip and username = :username";
                    $curr_attempts = 1;

                }

                $stmt2 = $db->conn->prepare($sql);
                $stmt2->bindParam(':attempts', $curr_attempts);
                $stmt2->bindParam(':ip', $ip_address);
                $stmt2->bindParam(':lastlogin', $datetimeNow);
                $stmt2->bindParam(':username', $username);
                $stmt2->execute();

            }

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        //Determines returned value ('true' or error code) (ternary)
        $resp = ($err == '') ? 'true' : $err;

        return $resp;

    }

}
