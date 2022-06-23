<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //get an image from the public folder

        //make an arrazy with all the image of the categories
        $categories = array(
            array(
                "name" => "Fruits",
                "image" => storage_path('mafermelocale/images/category/fruits.png'),
                "description" => "Dans le langage courant et en cuisine, un fruit est un aliment végétal, à la saveur sucrée, généralement consommé cru.",
            ),
            array(
                "name" => "Produits laitiers",
                "image" => storage_path('mafermelocale/images/category/produits_laitiers.png'),
                "description" => "Les produits laitiers, ou laitages, sont les laits ou les transformations alimentaires obtenus à partir de lait.",
            ),
            array(
                "name" => "Huiles et graisses",
                "image" => storage_path('mafermelocale/images/category/huiles_et_graisses.png'),
                "description" => "Les huiles et graisses sont des produits alimentaires riches en matières grasses.",
            ),
            array(
                "name" => "Légumes et légumineuses",
                "image" => storage_path('mafermelocale/images/category/legumes_et_legumineuses.png'),
                "description" => "Un légume est la plante ou une partie comestible d'une espèce potagère.",
            ),
            array(
                "name" => "Céréales",
                "image" => storage_path('mafermelocale/images/category/cereales.png'),
                "description" => "Les céréales sont des plantes monocotylédones de la famille des Gramineae.",
            ),
            array(
                "name" => "Viandes et poissons",
                "image" => storage_path('mafermelocale/images/category/viandes_et_poissons.png'),
                "description" => "La viande et le poisson faites de protéines animales, sources d'acides aminés essentiels, indispensables à de nombreuses fonctions de l'organisme.",
            ),
            array(
                "name" => "Sucreries",
                "image" => storage_path('mafermelocale/images/category/sucreries.png'),
                "description" => "Les sucreries sont des produits alimentaires riches en sucres.",
            ),
            array(
                "name" => "Condiments",
                "image" => storage_path('mafermelocale/images/category/condiments.png'),
                "description" => "Un condiment est une substance destinée à assaisonner, qui relève la saveur des préparations culinaires.",
            ),
            array(
                "name" => "Boissons",
                "image" => storage_path('mafermelocale/images/category/boissons.png'),
                "description" => "Une boisson, ou un breuvage, est un liquide destiné à la consommation. On trouve des boissons froides ou chaudes, gazeuses, alcoolisées ou non alcoolisées."
            ),
            array(
                "name" => "Autres",
                "image" => storage_path('mafermelocale/images/category/autres.png'),
                "description" => "Autres est une catégorie qui regroupe tous les produits qui ne sont pas dans les autres catégories. (Savons, tissus, crèmes ...)"
            ),
            );

            //insert the categories in the database
            foreach ($categories as $category) {
                Category::create([
                    'name' => $category['name'],
                    'category_image' => $category['image'],
                    'description' => $category['description'],
                ]);
            }
    }
}
