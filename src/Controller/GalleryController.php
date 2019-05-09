<?php


namespace App\Controller;

use App\Model\CategoriesManager;
use App\Model\ImageManager;

class GalleryController extends AbstractController
{
    public function categories()
    {
        $categoriesManager = new CategoriesManager();
        $categories = $categoriesManager->selectAll();
        return $this->twig->render('Gallery/gallery.html.twig', ['categories' => $categories]);
    }

    public function showCategory($id)
    {
        $imageManager = new ImageManager();
        $images = $imageManager->selectAllById($id);
        return $this->twig->render('Gallery/categoryimages.html.twig', ['images' => $images]);
    }

    public function deleteimagebyid($id)
    {
        $imageManager = new ImageManager();

        $image = $imageManager->selectOneById($id);
        var_dump($image);
        if (file_exists(substr($image['name'], 1))) {
            unlink(substr($image['name'], 1));
        }

        $imageManager->deleteById($id);
        header('Location:/gallery/showcategory/'.$image['categories_id']);
    }
}
