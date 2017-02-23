# Login-mit-Email-Bestaetigung
LoginSystem mit PHP, SQL, Bootstrap. 

Nutzer registriert sich und erhält eine Mail mit Bestätigungs-link

Erst nach der Bestätigung kann der neue Nutzer sich einloggen


Der Nutzer kann sein Passwort ändern, wenn er sein Passwort vergessen hat (Nach missglückten Anmeldeversuchen).

Er erhält über Mail einen Link um sein Passwort zu ändern


- PHP Mailer und Gmail SMTP (PHPMailer library: https://sourceforge.net/projects/phpmailer/ )
- Bootstrap Grid und Forms 
- Eingabevalidierung (bei Neuanmeldung) mit jQuery 
- SQL-Datenank: login.sql
- Hintergrundbilder aus : https://github.com/BlackrockDigital/startbootstrap by davidtmiller


<p align="center">
  <img src="https://s19.postimg.org/vc7ghhter/index.png" width="280"/>
  <img src="https://s19.postimg.org/5bgadmsrn/neu_Anmelden.png" width="280"/>
  <img src="https://s19.postimg.org/eutni37s3/home.png" width="280"/>
</p>
<p align="center">
  <img src="https://s19.postimg.org/rie08cc2r/fpasswort.png" width="280"/>
  <img src="https://s19.postimg.org/hmcx8p6ar/resetpass.png" width="280"/>
  <img src="https://s19.postimg.org/id5neh8o3/resetpass2.png" width="280"/>
</p>

Update 20.01.17 Eingabevalidierung mit Javascript (alternativ auch mich Parsley.js möglich)
<p align="left">
  <img src="https://s19.postimg.org/8ux66bp5v/signup_valid.png" width="280"/>
</p>

Es fehlt noch Passwort Hashing (momentan mit Md5)

Update 23.02.17 Bugs:
-Veraltete Version von PHP Mailer: Fehlermeldung bei Neuanmeldung des Nutzers "preg_replace(): The /e modifier is no longer supported"
-Fehlende Betreffzeile in Bestätigungsmail


<h2> How to install </h2>
- download, entpacken, Datenbank: login.sql
- in User Class PHP Mailer Einstellungen: Email und Passwort eintragen
