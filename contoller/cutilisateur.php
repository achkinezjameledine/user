<?php

require "../configuti.php";
require "../model/utilisateur.php";

class UserController
{
    public function listUsers()
    {
        $sql = "SELECT * FROM utilisateur";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function addUser($user)
    {
        $role = $user->getRole();
        $sql = "";
        if ($role === "admin") {
            $sql = "INSERT INTO utilisateur (firstName, lastName, email, role, pays, birthdate, telephone, age, gender, dateembauche, niveauacces) VALUES (:firstName, :lastName, :email, :role, :pays, :birthdate, :telephone, :age, :gender, :dateembauche, :niveauacces)";
        } else if ($role === "etudiant") {
            $sql = "INSERT INTO utilisateur (firstName, lastName, email, role, pays, birthdate, telephone, age, gender, niveauetude, specialisation) VALUES (:firstName, :lastName, :email, :role, :pays, :birthdate, :telephone, :age, :gender, :niveauetude, :specialisation)";
        }

        $db = config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            // Bind parameters based on the selected role
            if ($role === "admin") {
                $query->execute([
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "role" => $user->getRole(),
                    "pays" => $user->getPays(),
                    "birthdate" => $user->getBirthdate(),
                    "telephone" => $user->getTelephone(),
                    "age" => $user->getAge(),
                    "gender" => $user->getGender(),
                    "dateembauche" => $user->getDateEmbauche(),
                    "niveauacces" => $user->getNiveauAcces(),
                ]);
            } else if ($role === "etudiant") {
                $query->execute([
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "role" => $user->getRole(),
                    "pays" => $user->getPays(),
                    "birthdate" => $user->getBirthdate(),
                    "telephone" => $user->getTelephone(),
                    "age" => $user->getAge(),
                    "gender" => $user->getGender(),
                    "niveauetude" => $user->getNiveauEtude(),
                    "specialisation" => $user->getSpecialisation(),
                ]);
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function updateUser($userId, $firstName, $lastName, $email, $role, $pays, $birthdate, $telephone, $age, $gender, $numeroEtudiant = null)
    {
        $sql = "";
        if ($role === "admin") {
            $sql = "UPDATE utilisateur SET firstName = :firstName, lastName = :lastName, email = :email, role = :role, pays = :pays, birthdate = :birthdate, telephone = :telephone, age = :age, gender = :gender WHERE id = :userId";
        } else if ($role === "etudiant") {
            $sql = "UPDATE utilisateur SET firstName = :firstName, lastName = :lastName, email = :email, role = :role, numeroEtudiant = :numeroEtudiant, pays = :pays, birthdate = :birthdate, telephone = :telephone, age = :age, gender = :gender WHERE id = :userId";
        }

        $db = config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            // Bind parameters based on the selected role
            if ($role === "admin") {
                $query->execute([
                    "userId" => $userId,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "email" => $email,
                    "role" => $role,
                    "pays" => $pays,
                    "birthdate" => $birthdate,
                    "telephone" => $telephone,
                    "age" => $age,
                    "gender" => $gender,
                ]);
            } else if ($role === "etudiant") {
                $query->execute([
                    "userId" => $userId,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "email" => $email,
                    "role" => $role,
                    "numeroEtudiant" => $numeroEtudiant,
                    "pays" => $pays,
                    "birthdate" => $birthdate,
                    "telephone" => $telephone,
                    "age" => $age,
                    "gender" => $gender,
                ]);
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteUserById($userId)
    {
        // Construisez votre requête SQL pour supprimer l'utilisateur en fonction de l'ID
        $sql = "DELETE FROM utilisateur WHERE id = :userId";
        $db = Config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            $query->execute([
                "userId" => $userId
            ]);
            // Gérer la suppression réussie (redirection, message, etc.)
        } catch (Exception $e) {
            // Gérer les erreurs (affichage, journalisation, etc.)
            die("Erreur lors de la suppression de l'utilisateur: " . $e->getMessage());
        }
    }
}
?>







