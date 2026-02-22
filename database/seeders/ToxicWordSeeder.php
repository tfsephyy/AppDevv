<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToxicWord;

class ToxicWordSeeder extends Seeder
{
    public function run()
    {
        // Tagalog Single Words
        $tagalogWords = [
            'Putangina', 'Tangina', 'Puta', 'Gago', 'Gaga', 'Ulol', 'Tarantado', 'Tarantada',
            'Bwisit', 'Leche', 'Lintik', 'Kupal', 'Pakshet', 'Bobo', 'Boba', 'Tanga',
            'Tangaina', 'Inutil', 'Hudas', 'Demonyo', 'Peste', 'Loko', 'Loka', 'Bubuyog',
            'Taena', 'Taeni', 'Hanapbuhay', 'Siraulo', 'Gunggong', 'Timang', 'Ulopong',
            'Hayop', 'Aso', 'Baboy', 'Ungas', 'Amalayer', 'Tangek', 'Tengek', 'Pestehin',
            'Kolokoy', 'Puyet', 'Susmaryosep', 'Bwakanang', 'Bwak', 'Shunga', 'Shungak',
            'Shuta', 'Punyeta', 'Punyetangina', 'Lintikan', 'Etits', 'Burat', 'Pwet',
            'Walanghiyang', 'Huwad', 'Tinalo', 'Tunay na kupal', 'Umasa ka pa', 'Hudas ka',
            'Punyetang buhay'
        ];

        // Tagalog Phrases
        $tagalogPhrases = [
            'Putangina mo', 'Tangina mo', 'Gago ka', 'Ulol ka', 'Tarantado ka', 'Tanga ka',
            'Bobo ka', 'Inutil ka', 'Leche ka', 'Lintik ka', 'Kupal ka', 'Bwisit ka',
            'Sana ma-bwisit ka', 'Hindi ka marunong', 'Walang kwenta ka', 'Ang bobo mo grabe',
            'Sira ulo ka', 'Daming reklamo', 'Ang tanga mo sobra', 'Walang hiya ka',
            'Peste ka', 'Sana sapian ka ng demonyo', 'Ang kupal mo', 'Ang kapal ng mukha mo',
            'Sana mauntog ka', 'Wala kang utak', 'Buti pa mawala ka', 'Hindi ka nakakatulong',
            'Nakakabwisit ka', 'Nakakairita ka', 'Tangina buhay', 'Tangina naman',
            'Puta ano ba yan', 'Bwiset na araw', 'Tanga mo talaga', 'Ang slow mo',
            'Ano ba utak mo', 'Tigil tigilan mo ako', 'Shut up tangina', 'Wag kang tanga'
        ];

        // English Single Words
        $englishWords = [
            'Fuck', 'Shit', 'Bitch', 'Asshole', 'Bastard', 'Crap', 'Dick', 'Pussy',
            'Prick', 'Moron', 'Idiot', 'Stupid', 'Dumbass', 'Jackass', 'Dipshit',
            'Scumbag', 'Trash', 'Clown', 'Loser', 'Freak'
        ];

        // English Phrases
        $englishPhrases = [
            'Fuck you', 'You\'re stupid', 'Shut the fuck up', 'Fuck off', 'You\'re useless',
            'You\'re an idiot', 'Go to hell', 'You\'re a piece of shit', 'You\'re annoying as fuck',
            'What the fuck is wrong with you', 'You\'re such a loser', 'You\'re pathetic',
            'Don\'t waste my time', 'I don\'t give a shit', 'You\'re trash', 'Get lost',
            'Screw you', 'You\'re a clown', 'You\'re dumb as hell', 'Don\'t talk to me'
        ];

        // Insert Tagalog Words
        foreach ($tagalogWords as $word) {
            ToxicWord::create([
                'word' => strtolower($word),
                'type' => 'word',
                'language' => 'tagalog'
            ]);
        }

        // Insert Tagalog Phrases
        foreach ($tagalogPhrases as $phrase) {
            ToxicWord::create([
                'word' => strtolower($phrase),
                'type' => 'phrase',
                'language' => 'tagalog'
            ]);
        }

        // Insert English Words
        foreach ($englishWords as $word) {
            ToxicWord::create([
                'word' => strtolower($word),
                'type' => 'word',
                'language' => 'english'
            ]);
        }

        // Insert English Phrases
        foreach ($englishPhrases as $phrase) {
            ToxicWord::create([
                'word' => strtolower($phrase),
                'type' => 'phrase',
                'language' => 'english'
            ]);
        }
    }
}
