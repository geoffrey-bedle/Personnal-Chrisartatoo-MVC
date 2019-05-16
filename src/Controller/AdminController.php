<?php


namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\CategoriesManager;
use App\Model\EvenementsManager;
use App\Model\ImageManager;

class AdminController extends AbstractController
{


    public function admin()
    {
        $categoriesManager = new CategoriesManager();
        $categories = $categoriesManager->selectAll();
        if ($_SESSION['status'] != 1) {
            header('Location:/');                       //renvoie sur l'accueil si pas administrateur
        }
        return $this->twig->render('Admin/admin.html.twig', ['categories' => $categories]);
    }

    public function addArticle()
    {

        if (isset($_POST['submit'])) {
            $maxi_size = 1000000;
            $upload_dir = 'assets/upload/articles';
            $filename = '';

            for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                $size = $_FILES['upload']['size'][$i];
                $file = $_FILES['upload']['name'][$i];
                $type = $_FILES['upload']['type'][$i];
                $types = ['image/jpeg', 'image/png', 'image/gif'];

                if (($size < $maxi_size) && (in_array($type, $types))) {
                    $name = $_FILES['upload']['name'][$i];
                    $infos = new \SplFileInfo($name);
                    $ext = $infos->getExtension();
                    $filename = 'image_' . uniqid() . '.' . $ext;

                    $tmp_name = ($_FILES['upload']['tmp_name'][$i]);
                    move_uploaded_file($tmp_name, "$upload_dir/$filename");
                }

                if (isset($_FILES['upload']['name'])) {
                    $bddname = 'assets/upload/articles/' . $filename;
                } else {
                    $bddname = "";
                }

                $ArticleManager = new ArticleManager();
                $ArticleManager->insert($_POST, $bddname);
            }
        }

        header('Location:/Admin/admin');
    }

    public function addImage()
    {

        if (isset($_POST['submit'])) {
            $maxi_size = 1000000;
            $upload_dir = 'assets/upload/galleryImg';
            $filename = '';
            for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                $size = $_FILES['upload']['size'][$i];
                $file = $_FILES['upload']['name'][$i];
                $type = $_FILES['upload']['type'][$i];
                $types = ['image/jpeg', 'image/png', 'image/gif'];

                if (($size < $maxi_size) && (in_array($type, $types))) {
                    $name = $_FILES['upload']['name'][$i];
                    $infos = new \SplFileInfo($name);
                    $ext = $infos->getExtension();
                    $filename = 'image_' . uniqid() . '.' . $ext;


                    $tmp_name = ($_FILES['upload']['tmp_name'][$i]);
                    move_uploaded_file($tmp_name, "$upload_dir/$filename");
                }
                $bddname = '/assets/upload/galleryImg/' . $filename;

                $imageManager = new ImageManager();
                $imageManager->insertImage($_POST, $bddname);
                header('Location: Admin/admin');
            }
        }
    }

    public function addEvenement()
    {
        $evenementManager = new EvenementsManager();
        $evenements = $evenementManager->insert($_POST);
        header('Location: Admin/admin');
    }

    public function show()
    {
        $articlesmanager = new ArticleManager();
        $articles = $articlesmanager->selectAll();

        $evenementsManager = new EvenementsManager();
        $evenements = $evenementsManager->selectAll();

        $categoriesManager = new CategoriesManager();
        $categories = $categoriesManager->selectAll();

        return $this->twig->render('Admin/show.html.twig', ['articles' => $articles,
            'evenements' => $evenements,
            'categories' => $categories]);
    }

    public function editArticleById($id)
    {
        //TODO BUG modification article supprime l'image
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_FILES['upload']['name'])) {                //si rien n'est uploadé
                $_POST['image'] = $article['image'];                //$_POST['image'] est égal à ce qu'il y a en bdd
            } else {
                $upload_dir = 'assets/upload/articles';

                $name = $_FILES['upload']['name'];
                $size = $_FILES['upload']['size'];
                $file = $_FILES['upload']['name'];
                $type = $_FILES['upload']['type'];
                $types = ['image/jpeg', 'image/png', 'image/gif'];

                var_dump($article['image']);
                $infos = new \SplFileInfo($name);
                $ext = $infos->getExtension();
                $filename = 'image_' . uniqid() . '.' . $ext;


                $tmp_name = ($_FILES['upload']['tmp_name']);
                move_uploaded_file($tmp_name, "$upload_dir/$filename");
                $_POST['image'] = $upload_dir . '/' . $filename;
            }
            $upload_dir = 'assets/upload/articles';
            if (file_exists($article['image']) && $article['image'] != $upload_dir . '/') {
                unlink($article['image']);
            }
            $articleManager->update($id, $_POST);
            header('Location:/admin/show');
        }
        return $this->twig->render('Admin/editarticle.html.twig', ['article' => $article]);
    }

    public function deleteArticleById($id)
    {

        $articleManager = new ArticleManager();
        $articles = $articleManager->selectOneById($id);

        if (file_exists($articles['image'])) {
            unlink($articles['image']);
        }
        $articleManager->delete($id);

        header('Location: /Admin/show');
    }

    public function deleteEvenmentById($id)
    {
        $evenementManager = new EvenementsManager();
        $evenementManager->delete($id);
        header('Location: /Admin/show');
    }

    public function updatEvenmentById($id)
    {

        $evenementsManager = new EvenementsManager();
        $evenement = $evenementsManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evenementsManager->update($id, $_POST);
            header('Location:/Admin/show');
        }

        return $this->twig->render('Admin/editevenment.html.twig', ['evenement' => $evenement]);
    }

    public function addcategory()
    {

        if (isset($_POST['submit'])) {
            $maxi_size = 1000000;
            $upload_dir = 'assets/upload/categories';

            $filename = '';


            $types = ['image/jpeg', 'image/png', 'image/gif'];


            $name = $_FILES['upload']['name'];
            $infos = new \SplFileInfo($name);
            $ext = $infos->getExtension();
            $filename = 'image_' . uniqid() . '.' . $ext;

            $tmp_name = ($_FILES['upload']['tmp_name']);
            move_uploaded_file($tmp_name, "$upload_dir/$filename");

            if (isset($_FILES['upload']['name'])) {
                $bddname = '/assets/upload/categories/' . $filename;
            } else {
                $bddname = "";
            }
            $categoriesManager = new CategoriesManager();
            $categoriesManager->insert($_POST, $bddname);
            header('Location:/Admin/admin');
        }
    }

    public function deleteCategoryById($id)
    {
        $categoriesManager = new CategoriesManager();
        $category = $categoriesManager->selectOneById($id);

        if (file_exists(substr($category['image'], 1))) {
            unlink(substr($category['image'], 1));
        }
        $categoriesManager->deleteById($id);
        header('Location:/Admin/admin');
    }
}
