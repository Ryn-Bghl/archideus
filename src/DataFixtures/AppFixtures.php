<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();
        $categories = [];

        $categoryData = [
            "indoor" => [
                "name" => "Plantes d’intérieur",
                "description" =>
                    "Des plantes décoratives adaptées à la vie en intérieur.",
            ],
            "succulents" => [
                "name" => "Succulentes",
                "description" =>
                    "Des plantes qui stockent l’eau et demandent peu d’arrosage.",
            ],
            "aromatic" => [
                "name" => "Aromatiques",
                "description" =>
                    "Des plantes parfumées à cultiver et à utiliser en cuisine.",
            ],
        ];

        foreach ($categoryData as $key => $data) {
            $category = new Category()
                ->setName($data["name"])
                ->setSlug($slugger->slug($data["name"])->lower()->toString())
                ->setDescription($data["description"]);

            $manager->persist($category);
            $categories[$key] = $category;
        }

        $plants = [
            [
                "name" => "Monstera",
                "description" =>
                    "Une plante tropicale appréciée pour ses grandes feuilles découpées.",
                "price" => 2490,
                "stock" => 12,
                "careLevel" => "Modéré",
                "light" => "Lumière indirecte",
                "watering" => "Quand le terreau sèche en surface",
                "category" => "indoor",
            ],
            [
                "name" => "Ficus lyrata",
                "description" =>
                    "Un ficus d’intérieur aux grandes feuilles en forme de violon.",
                "price" => 3290,
                "stock" => 8,
                "careLevel" => "Modéré",
                "light" => "Lumière vive indirecte",
                "watering" => "Quand le terreau sèche en surface",
                "category" => "indoor",
            ],
            [
                "name" => "Pothos",
                "description" =>
                    "Une plante grimpante robuste aux feuilles en forme de cœur.",
                "price" => 1590,
                "stock" => 20,
                "careLevel" => "Facile",
                "light" => "Lumière indirecte ou faible",
                "watering" => "Quand le terreau sèche en surface",
                "category" => "indoor",
            ],
            [
                "name" => "Echeveria",
                "description" =>
                    "Une succulente en rosette aux feuilles charnues.",
                "price" => 890,
                "stock" => 18,
                "careLevel" => "Facile",
                "light" => "Lumière vive",
                "watering" => "Rarement, terreau sec",
                "category" => "succulents",
            ],
            [
                "name" => "Aloe vera",
                "description" =>
                    "Une succulente aux longues feuilles épaisses et dentelées.",
                "price" => 1290,
                "stock" => 14,
                "careLevel" => "Facile",
                "light" => "Lumière vive",
                "watering" => "Rarement, terreau sec",
                "category" => "succulents",
            ],
            [
                "name" => "Cactus boule",
                "description" =>
                    "Un petit cactus rond adapté aux intérieurs lumineux.",
                "price" => 990,
                "stock" => 16,
                "careLevel" => "Facile",
                "light" => "Lumière directe ou vive",
                "watering" => "Très rarement, terreau sec",
                "category" => "succulents",
            ],
            [
                "name" => "Basilic",
                "description" =>
                    "Une herbe aromatique aux feuilles parfumées, idéale en cuisine.",
                "price" => 450,
                "stock" => 25,
                "careLevel" => "Facile",
                "light" => "Lumière vive",
                "watering" => "Régulièrement, terreau légèrement humide",
                "category" => "aromatic",
            ],
            [
                "name" => "Menthe",
                "description" =>
                    "Une herbe aromatique vivace aux feuilles fraîches et parfumées.",
                "price" => 450,
                "stock" => 22,
                "careLevel" => "Facile",
                "light" => "Lumière indirecte",
                "watering" => "Régulièrement, terreau légèrement humide",
                "category" => "aromatic",
            ],
        ];

        foreach ($plants as $data) {
            $plant = new Product()
                ->setName($data["name"])
                ->setSlug($slugger->slug($data["name"])->lower()->toString())
                ->setDescription($data["description"])
                ->setPrice($data["price"])
                ->setStock($data["stock"])
                ->setCareLevel($data["careLevel"])
                ->setLight($data["light"])
                ->setWatering($data["watering"])
                ->setCategory($categories[$data["category"]]);

            $manager->persist($plant);
        }

        $manager->flush();
    }
}
