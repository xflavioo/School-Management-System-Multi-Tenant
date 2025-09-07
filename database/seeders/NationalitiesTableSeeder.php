<?php
namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;


class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nationals = array(
            'Afegão', 'Albanês', 'Argelino', 'Americano', 'Andorrano', 'Angolano', 'Antiguano', 'Argentino', 'Armênio', 'Australiano', 'Austríaco', 'Azerbaijano', 'Bahamense', 'Bareinita', 'Bangladês', 'Barbadiano', 'Barbudano', 'Botsuanês', 'Bielorrusso', 'Belga', 'Belizenho', 'Beninense', 'Butanês', 'Boliviano', 'Bósnio', 'Brasileiro', 'Britânico', 'Bruneano', 'Búlgaro', 'Burquinês', 'Birmanês', 'Burundês', 'Cambojano', 'Camaronês', 'Canadense', 'Cabo-verdiano', 'Centro-africano', 'Chadiano', 'Chileno', 'Chinês', 'Colombiano', 'Comorense', 'Congolês', 'Costa-riquenho', 'Croata', 'Cubano', 'Cipriota', 'Tcheco', 'Dinamarquês', 'Djiboutiano', 'Dominicano', 'Holandês', 'Timorense', 'Equatoriano', 'Egípcio', 'Emiradense', 'Equato-guineense', 'Eritreu', 'Estoniano', 'Etíope', 'Fijiano', 'Filipino', 'Finlandês', 'Francês', 'Gabonês', 'Gambiano', 'Georgiano', 'Alemão', 'Ganês', 'Grego', 'Granadino', 'Guatemalteco', 'Guineense', 'Guianense', 'Haitiano', 'Hondurenho', 'Húngaro', 'Islandês', 'Indiano', 'Indonésio', 'Iraniano', 'Iraquiano', 'Irlandês', 'Israelense', 'Italiano', 'Marfinense', 'Jamaicano', 'Japonês', 'Jordaniano', 'Cazaque', 'Queniano', 'Kuwaitiano', 'Quirguiz', 'Laosiano', 'Letão', 'Libanês', 'Liberiano', 'Líbio', 'Liechtensteinense', 'Lituano', 'Luxemburguês', 'Macedônio', 'Malgaxe', 'Malauiano', 'Malaio', 'Maldivo', 'Maliano', 'Maltês', 'Marshallês', 'Mauritano', 'Mauriciano', 'Mexicano', 'Micronésio', 'Moldavo', 'Monegasco', 'Mongol', 'Marroquino', 'Lesotense', 'Botsuanês', 'Moçambicano', 'Namibiano', 'Nauruano', 'Nepalês', 'Neozelandês', 'Nicaraguense', 'Nigeriano', 'Nigerino', 'Norte-coreano', 'Norte-irlandês', 'Norueguês', 'Omanense', 'Paquistanês', 'Palauense', 'Panamenho', 'Papua-novo-guineense', 'Paraguaio', 'Peruano', 'Polonês', 'Português', 'Catarense', 'Romeno', 'Russo', 'Ruandês', 'São-lucense', 'Salvadorenho', 'Samoano', 'São-marinense', 'São-tomense', 'Saudita', 'Escocês', 'Senegalês', 'Sérvio', 'Seichelense', 'Serra-leonês', 'Singapurense', 'Eslovaco', 'Esloveno', 'Salomonense', 'Somali', 'Sul-africano', 'Sul-coreano', 'Espanhol', 'Sri-lankês', 'Sudanês', 'Surinamês', 'Suazi', 'Sueco', 'Suíço', 'Sírio', 'Taiwanês', 'Tadjique', 'Tanzaniano', 'Tailandês', 'Togolês', 'Tonganês', 'Trinitário', 'Tunisiano', 'Turco', 'Tuvaluano', 'Ugandense', 'Ucraniano', 'Uruguaio', 'Uzbeque', 'Venezuelano', 'Vietnamita', 'Galês', 'Iemenita', 'Zambiano', 'Zimbabuense'
        );

        foreach ($nationals as $n) {
            Nationality::create(['name' => $n]);
        }
    }
}
