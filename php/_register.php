<?php
/**
 * Created by PhpStorm.
 * User: DassinRock
 * Date: 13/08/2018
 * Time: 23:19
 */
//Verification de la soumission du boutton: signup
if (isset($_POST['signup'])) {
	if (not_empty(['status', 'region', 'password', 'password_confirm'])) {

		$errors = [];
		extract($_POST);
		$gender = $_SESSION['gender'];
		$url = ($gender == 1) ? IMGDIR.'man.png' : IMGDIR.'woman.png';

//Champ status: single or couple
		if (!is_numeric($status)){
			$single = ($status == 'yes')? 1 : 0;
			}else{
				$errors[] = "Soit t'es célibataire / Soit t'es en couple ?";
			}

//Champ region: city, country
		if (is_numeric($region)){
			if(($region == 1)||($region == 2)){
				$city = $region;
				$country = 1;
				$country_code = 242;
			}else{
				$errors[] = "T'es pas du pays toi !";
			}
		}else{
			$errors[] = "Erreur au niveau du champ: ville";
		}

//Champ password, password confirm
		if (mb_strlen($password) < 6) {
			$errors[] = "Encore un effort, ton mot de passe est trop court! (6 caractères au minimum)";
		} else {
			if ($password != $password_confirm) {
				$errors[] = "Les deux mots de passe ne concordent pas";
			}
		}

//Compte le nombre d'erreurs puis verifie que celui-ci est nul
		if (count($errors) == 0) {
			//Envoi de mail de confirmation
			$from = WEBSITE_NOREPLY;
			$to = WEBSITE_REGISTER;
			$subject = WEBSITE_NAME . " - NOUVELLE INSCRIPTION";
			$password = password_hash($password,PASSWORD_BCRYPT);
			$token = random_main_id(110497,999999);
			$ip = $_SERVER['REMOTE_ADDR'];
			$today = date('d-m-Y H:i:s');

			//Sauvegarde dans une variable de la vue du mail d'activation
			ob_start();
			require('views/mail/activation.view.php');
			$content = ob_get_clean();

			//Création des entetes du mail d'activation puis son envoi suivi de l'affichage d'une notification
			$headers = 'From: ' .$from . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text\html; charset=iso-8859-1' . "\r\n";
			mail($to, $subject, $content, $headers);
			set_flash("Un code d'activation et des instructions 
                       <br>vous sera envoyé  via sms dans les heures qui suivent<br>
                       à travers votre numéro de téléphone.<br>
                       ",$success);

			//Insertion dans la db des données traitées précédemment
			$q = $db->prepare("INSERT INTO user(main_id, phone, birthdate, gender, single, img, ip, city, country, password, token, since)
                                        VALUES(:main_id, :phone, :birthdate, :gender, :single, :img, :ip, :city, :country, :password, :token, :since)");
			$q->execute([
				'main_id'=>sha1(uniqid()),
				'phone'=>$phone,
				'birthdate'=>$birthdate,
				'gender'=>$gender,
				'single'=>$single,
				'img'=>$url,
				'ip'=>$ip,
				'city'=>$city,
				'country'=>$country,
				'password'=>$password,
				'token'=>$token,
				'since'=>time()

			]);


			session_destroy();
			$_SESSION = [];
			redirect('index.php');

		} else{
			save_input_data();
		}

	} else {
		$errors[] = "Veuillez remplir tous les champs!";
		save_input_data();
	}
}else{

}