<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <H1>SandBox Models</H1>

    <div class="content">
        <?if(isset($_SESSION["error"]) && $_SESSION["error"] !== ""){
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>".$_SESSION['error']."</div>"; 
        }else if(isset($_SESSION["success"]) && $_SESSION["success"] !== ""){
            echo "<div class=\"alert alert-success alert-dismissible fade show\" role='alert'>".$_SESSION['success']."</div>";
        }?>


        <h3> Test annee scolaire </h3>
        <?php
            var_dump(Matiere::first(1)->anneeScolaire);
            echo "</br></br></br>";
            var_dump(Classe::first(1)->anneeScolaire);
            echo "</br></br></br>";
            var_dump(AnneeScolaire::first(1)->classes);
            echo "</br></br></br>";
            var_dump(AnneeScolaire::all());
        ?>
        <h3> TEST import CSV </h3>
        <form method="POST" action="" name="loadFileForm" enctype="multipart/form-data">
            <input type="file" id="file-upload" name="uploadedFile" accept=".csv"/>
            <input type="submit" name="Load" value="Load"/>
        </form>


        <h3> TEST import CSV PROF</h3>
        <form method="POST" action="" name="loadFileForm" enctype="multipart/form-data">
            <input type="file" id="file-upload" name="uploadedFile" accept=".csv"/>
            <input type="submit" name="LoadProf" value="Load"/>
        </form>
        <?
            //Mailer::sendEmail("SuperPompier", "benoit.de-sousa@uha.fr", "BIenvenue sur smartgrades", "De Sousa", "Benoît", 1);
        ?>
        <?php for($i = 0; $i < 10; $i++){?>
            </br>
        <?php } ?>
        <h3>Test Question model with pivot table QuestionHasExamen</h3>
        <?php
            var_dump(Question::all()); //all questions
            echo "<p>Question contenu id 1 => " . Question::first(1)->contenu . "</p></br>";
            var_dump(Question::first(1)->examens);
            echo "<p> Examen related to Question id 1 =>" . Question::first(1)->examens[0]->intitule . 
                 " || DATE = " . Question::first(1)->examens[0]->date_examen ."</p></br>";

                 
        ?>

        <h4> all questions of an examen </h4>
        
        <?php
            $examen = Examen::first(1);

            foreach($examen->questions as $q){
        ?>

        <table class="table">
                <tr><th>Contenu question </th><th>Commentaire</th><th>Points</th><th>Date création</th></tr>
                <?php
                    echo "<tr>";
                    echo "<td>" . $q->contenu . "</td><td>" . $q->commentaire . "</td><td>" . $q->points . "</td><td>" . $q->created_at . "</td>";
                    echo "</tr>";
                }       
                ?>

        </table>
    </div>
    
    <div class="content">
        <h3>All students based on prof "3021001" and matiere JAVA (provided by this prof)</h3>
        <table class="table">
            <?php
            //données connues par l'affichage HTML---v---
            $id_prof = 3021001;
            $id_mat = 2;
            //---^---
            $professeur = Professeur::first(["numero_professeur", "=", $id_prof], []);
            $matiere = Matiere::first(["id", "=", $id_mat], []);

            echo "donnée connue -> numero_professeur: $professeur->numero_professeur</br>";
            echo "donnée connue -> nom_mat: $matiere->name_matiere et porte id: $matiere->id </br>";

            $targetIndex = -1;
            foreach ($professeur->matieres as $indexLocal => $matiereProf) {
                if ($matiereProf->id == $matiere->id) {
                    $targetIndex = $indexLocal;
                    break;
                }
            }
            $targetMatiere = $professeur->matieres[$targetIndex];
            $students = $professeur->getListStudentMatiere($targetMatiere);
            echo "liste des élèves appartenant à ce croisement: </br>";
            foreach ($students as $s) {
                echo "  - id: $s->id ; numéro étudiant: $s->numero_etudiant</br>";
            }

            echo "---Test with API request:---</br>";
            $etudiants = API::getListEtudiants_idProfIdMatiere_query($id_prof, $id_mat);
            foreach ($etudiants as $e) {
                echo "  - id: $e->id ; numéro étudiant: $e->numero_etudiant</br>";
            }
            ?>
        </table>
        <p>-------------------</p>
        <h3>Get all Matiere from one Professeur</h3>
        <table class="table">
            <?php
            //données connues par l'affichage HTML---v---
            $id_prof = 3021001;
            //---^---
            $professeur = Professeur::first(["numero_professeur", "=", $id_prof], []);
            echo "donnée connue -> numero_professeur: $professeur->numero_professeur</br>";
            foreach ($professeur->matieres as $matiere) {
                echo "  - matiere $matiere->name_matiere</br>";
            }
            echo "---Test with API request par l'id du prof:---</br>";
            $matieresDunProf = API::getListMatieres_idProf_query($id_prof);
            foreach ($matieresDunProf as $mp) {
                echo "  - matiere $mp->name_matiere</br>";
            }
            echo "---Test with API request par l'objet du prof:---</br>";
            $objProf = Professeur::first(["numero_professeur", "=", $id_prof], []);
            $matieresDunProf = API::getListMatieres_prof_query($objProf);
            foreach ($matieresDunProf as $mp) {
                echo "  - matiere $mp->name_matiere</br>";
            }
            ?>
        </table>
        <p>-------------------</p>
        <h3>Get the result of an authentification</h3>
        <table class="table">
            <?php
            //données connues par l'affichage HTML---v---
            $email = 'toto1@gmail.com';
            $userMDP = 'T0T0';
            //---^---
            echo "user: $email with input password: $userMDP </br>";
            $userExists = password_verify($userMDP, User::first(["email", "=", $email], [])->password);
            echo "  - authentification $userExists</br>";
            var_dump($userExists);
            echo "---Test with API request:---</br>";
            $userExitsAPI = API::getAuthentification_mailPwd_query($email, $userMDP);
            echo "  - authentification $userExitsAPI</br>";
            var_dump($userExists);
            ?>
        </table>
    </div>

    <div class="content">
        <H3>Details from Etudiant with numero_etudiant=2020003</H3>
        <?php
        $numero_etudiant = 2020003;
        $etudiant = API::getEtudiant_numeroEtudiant_query(2020003);

        var_dump($etudiant);
        var_dump($etudiant->user);
        ?>
    </div>

    <div class="content">
        <h3>All users with model use</h3>
        <table class="table">
            <?php

            $users = User::all();
            foreach ($users as $user) {
                echo "<tr><td>" . $user->name . "</td><td>$user->surname</td><td>$user->email</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="content">
        <h4>Samples Example</h4>
        <h5>Get professeur from user</h5>
        <? var_dump(User::first(6)->professeur()); ?>
        <?php
        $user = User::first(6);
        $prof = $user->professeur();

        echo "</br>$user->name $user->surname $user->email
                </br> PROF => $prof->numero_professeur $prof->id_gitlab ";

        $user = User::first(9);
        $admin = $user->administrateur();

        echo "</br></br>$user->name $user->surname $user->email
                </br> ADMIN => $admin->id</br>";

        //var_dump($Administrateur::first(1)->user()); //works reverse way

        //var_dump(Classe::all());
        //var_dump(Classe::first(1)->professeurs()); //show all the professors that has the classe id 1
        //var_dump(Professeur::first(1)->classes()); //show all the classes of professor with id 1

        //var_dump(Etudiant::all());

        //var_dump(Etudiant::first(1)->classe); //get classe linked to student with id 1
        //var_dump(Classe::first(1)->etudiants());

        //var_dump(Examen::all());// show all the exams

        /*echo "</br>";
                echo "MatiereName => " . Matiere::first(1)->name_matiere . " </br>";
                foreach(Matiere::first(1)->etudiants as $etu){ //show all students from Matiere with id 1
                    echo"id=>$etu->id ";
                }
                echo "</br>";*/
        //var_dump(Etudiant::first(1)->matieres); // all the matieres related to etudiant with id = 1

        //TODO: show NOTE from pivot table
        //var_dump(Etudiant::first(1)->examens); //show all exams related to etudiant with id = 1;
        //var_dump(Examen::first(1)->etudiants); //show all students related to exam with id = 1;

        //echo Matiere::first(1)->name_matiere."</br>";//show name of the matiere with id 1
        //var_dump(Matiere::first(1)->examens); //show all the examens related to the matiere with id = 1

        //echo Examen::first(1)->intitule . " " . Examen::first(1)->type . "</br>";
        //var_dump(Examen::first(1)->matieres);

        //echo "Target Exam =>" . Examen::first(1)->intitule . "</br>";
        //var_dump(Examen::first(1)->professeurs[0]->numero_professeur);
        //var_dump(Examen::first(1)->professeurs); //get all professeurs related to the exam with id 1 
        //var_dump(Professeur::first(1)->examens); //get all exams from professeur with id 1

        //$targetExamen = Examen::first(2);
        //$etudiant = Etudiant::first(1);

        //var_dump($etudiant->note($targetExamen)); //get note from a specific examen
        ?>
    </div>

    <div class="content">
        <H3>Pivot Table example</H3>
        <?php
        $mat = Matiere::first(1);

        $prof = Professeur::first(User::first(6)->professeur()->id);

        //var_dump($prof->matieres);
        echo "Targeted Matiere => $mat->id, name=>$mat->name_matiere</br>";
        $professeurs = $mat->professeurs;

        echo "All teachers related to the subject</br>";
        echo "<table class=\"table\">";
        echo "<thead>
                            <tr>
                            <th scope=\"col\">Numero_professeur</th>
                            <th scope=\"col\">id user</th>
                            <th scope=\"col\">id gitlab</th>
                            <th scope=\"col\">name</th>
                            <th scope=\"col\">surname</th>
                            </tr>
                        </thead>";

        foreach ($professeurs as $prof) {
            echo "<tr><td>" . $prof->numero_professeur . "</td><td>$prof->id_user</td><td>$prof->id_gitlab</td>";
            $user = $prof->user;
            echo "<td>$user->name</td><td>$user->surname</td></tr>";
        }

        echo "</table>";

        $firstRecordProf = $professeurs;
        ?>
    </div>


    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>