<h1>Projet InstantMessage</h1>

<h2>Description :</h2>

<p>Réalisation d'une messagerie en Symfony</p>

<h2>Contexte :</h2>

<p>Projet réalisé en équipe de 3.</p>

<h2>Technologies et frameworks utilisées :</h2>

<p>Intégration : Bootstrap, HTML5, CSS3</p>
<p>Animation : Javascript, jQuery</p>
<p>Base de donnée : PHPmyAdmin</p>
<p>Fonctionnement : Symfony 4</p>

<h2>Outils utilisés :</h2>

<p>Editeur de code: Visual Studio Code et PHP Storm</p>

<h2>Développeurs :</h2>

<p>Matthieu LE VERGER (MWMatthieuLV)</p>
<p>Lucas GOUDRY (lucasg60)</p>
<p>Romain MOINAT (romainmnt)</p>

<h2>Installation :</h2>

<h3>Creer un dossier .git pour cloner le projet, en écrivant dans un terminal de commande la commande suivante :</h3>
<code>git init<code>
<h3>Cloner le repository dans le dossier :</h3>
<code>git clone git@github.com:lucasg60/tpSymfony2.git<code>
<h3>Ouvrir le projet dans un éditeur de code tel que Visual Studio Code</h3>
<h3>Ouvrir un terminal de commande</h3>
<h3>Installer les dossiers var et vendors :</h3>
<code>Composer install</code>
<h3>Créer et remplir la base de donnée :</h3>
<code>php bin/console doctrine:database:create</code>
<code>php bin/console doctrine:schema:update --force</code>
<code>php bin/console doctrine:fixtures:load</code>
<h3>Lancer le serveur Symfony pour lancer le projet:</h3>
<code>symfony serve</code>

<h2>Comptes pour tester le projet<h2>
<p>Tout les comptes générés par les DataFixtures ont pour mot de passe "password"</p>
<p>Compte Administrateur : Admin</p>
<p>Mot de passe Administrateur : Password<p>





