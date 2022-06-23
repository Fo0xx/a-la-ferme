<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompleteFarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create a new farm called "Ferme Lachaud"
        $address = Address::create([
            "address" => "Le caillou",
            "postcode" => "61100",
            "city" => "Flers",
            "lon" => "-0.6662945",
            "lat" => "48.7132364",
        ]);

        $user = User::factory()->create([
            "first_name" => "Jean",
            "last_name" => "Dupont",
            "email" => "jean.dupont@lachaud.com",
            "role_id" => 1,
            "address_id" => $address->id,
        ]);

        $farm_details = Farm_details::create([
            "about" => "Dans la vallée Ornaise, à proximité de Flers, Sandrine et Pascal vous proposent une multitude de produits issus de l'élevage équin.

            La ferme vous reçoit, en famille ou en groupe sur rendez-vous, pour vous faire découvrir les différentes facettes du métier. Grâce à un diaporama commenté et animé, dans une salle remplie d'outils et de machines agricoles d'époque, vous apprendrez tout sur les chevaux ! Sous le soleil d'été, profitez des tables près des vergers pour vous rafraichir et vous reposer. Une aire de camping-car est aussi à votre disposition pour vous offrir « une escale détente ».
            
            Productions de la ferme : Lait de jument, la spécialité de la maison ! Retrouver aussi des produits inédits tels que le Koumis, une boisson à base de lait de jument fermenté. Éleveurs de père en fils, la famille élève ses chevaux et ânes avec la plus grande tendresse. La dégustation est gratuite. La ferme Lachaud proposent aux comités d'entreprises leurs spécialités et leurs alcools dans des coffrets agrémentés de divers produits fermiers locaux (les contacter pour les offres et devis).
            
            Productions labellisées Agriculture biologiques : Lait de jument lyophilisé certifié AG.",
            "farm_banner" => "https://images.pexels.com/photos/634612/pexels-photo-634612.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940",
            "business_mail" => "contact@lachaud.com",
            "phone" => "0231696964",
            "instagram_id" => "ecurie_equi_libre78",
            "facebook_id" => "EcurieDryOfficiel",
        ]);

        Farm::create([
            "name" => "Ferme Lachaud",
            "farm_image" => "https://images.pexels.com/photos/634612/pexels-photo-634612.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940",
            "short_description" => "La ferme équine lachaud vous accueille du lundi au samedi
            Nous vendons des produits équins (lait de jument, savon
            au lait de jument). Alors venez nombreux !",
            "address_id" => $address->id,
            "user_id" => $user->id,
            "farm_details_id" => $farm_details->id,
        ]);
    }
}
