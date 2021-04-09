<?php

namespace LanguageDetectorTest;

use LanguageDetector\LanguageDetector;
use PHPUnit\Framework\TestCase;

class LanguageDetectionTest extends TestCase
{
    /**
     * @var array
     */
    protected $availableLanguages = [
        'th',
        'mr',
        'sk',
        'pa',
        'ru',
        'el',
        'ar',
        'ta',
        'hr',
        'sq',
        'ja',
        'cs',
        'bn',
        'tl',
        'i-klingon',
        'it',
        'ro',
        'lt',
        'hi',
        'id',
        'bg',
        'lv',
        'gu',
        'he',
        'en',
        'vi',
        'sv',
        'ne',
        'et',
        'hu',
        'af',
        'pt',
        'de',
        'es',
        'zh-tw',
        'mk',
        'pl',
        'sl',
        'so',
        'zh-cn',
        'uk',
        'nl',
        'no',
        'ur',
        'da',
        'kn',
        'ko',
        'te',
        'fr',
        'sw',
        'ml',
        'fi',
        'tr',
        'fa',
    ];

    /**
     * Valid scenarios provider
     */
    public function getLanguageDetectionScenarios()
    {
        // expected, string, message
        return [
            ['', '', 'Should be empty'],
            ['af', 'Hi, dit is \'n frase in Afrikaans', 'Should be Afrikaans'],
            ['ar', 'مرحبا، وهذا هو عبارة باللغة العربية', 'Should be Arabic'],
            ['bg', 'Йоланд е шведски остров, разположен в Балтийско море, близо до град Калмар. Със своите 1344 km2 това е и вторият по големина остров в Швеция (след Готланд). Населението на острова към 31 декември 2013 година е 24 987 души, но по време на шведския празник Мидсомар на острова често се събират около 500 000 души. Остров Йоланд е естествено отделен от основната земя с протока Калмарсунд, но е достъпен посредством шесткилометровия мост Йоланд, изграден през 1972 година. Остров Йоланд е и най-малката историческа провинция на Швеция, която е част от бивше административно деление на Швеция. Съвременното административно деление включва остров Йоланд в рамките на лен Калмар.', 'Should be Bulgarian'],
            ['cs', 'Severní koruna je malé souhvězdí v severní části hvězdné oblohy. Jméno souhvězdí je inspirované jeho tvarem, nejjasnější hvězdy souhvězdí tvoří nepříliš dokonalý půlkruh. Je severním protějškem Jižní koruny. Je jedním z 48 souhvězdí, které uvádí ve svém díle z 2. století Almagest řecký astronom Ptolemaios a je jedním z 88 moderních souhvězdí. V antické mytologii je Severní koruna čelenkou či královskou korunou Ariadny, dcery řeckého krále Minóa a manželky boha Dionýsa. Po její smrti čelenku Dionýsos vyhodil na hvězdnou oblohu, aby ji již žádná jiná žena nemohla nosit. V jiných kulturách souhvězdí zpodobňuje orlí hnízdo či medvědí doupě.', 'Should be Czech'],
            ['da', 'Hej, dette er en sætning på dansk', 'Should be Danish'],
            ['de', 'Hallo, dies ist ein Begriff in der deutschen', 'Should be German'],
            ['el', 'Γεια, αυτό είναι μια φράση στα γερμανικά', 'Should be Greek'],
            ['en', 'Baryonyx was a theropod dinosaur of the early Cretaceous Period, about 130–125 million years ago. An identifying specimen of the genus was discovered in 1983 in Surrey, England; fragmentary specimens were later discovered in other parts of the United Kingdom and Iberia.', 'Should be English'],
            ['es', 'Hola, esta es una frase en español', 'Should be spanish'],
            ['et', 'Eesti, varem kirjutatud Eesti ametlikult Eesti Vabariigis, Eesti Eesti ja Eesti Vabariik on riik Põhja-Euroopas ja liikmesriigi Euroopa Liidu idakaldal mere Balti ja Lõuna-Soome lahes. Riik piirneb põhjas Soome lahe, lääne poolt Rootsi, lõunas Läti ja idas Venemaa. See riik on üldiselt grupeeritud Läti ja Leedu on geopoliitilises nimetatakse Balti riikides. Kuid kuna tema tagasipöördumist iseseisvuse 1991. aastal, Eesti taotleb lähemale Põhjamaades.', 'Should be Estonian'],
            ['fa', 'سلام، این یک جمله به زبان فارسی است', 'Should be Farsi'],
            ['fi', 'Hei, tämä on lauseen farsin', 'Should be Finnish'],
            ['fr', 'Bonjour, ceci est une phrase en français', 'Should be French'],
            ['gu', 'હાય, આ ગુજરાતી શબ્દસમૂહ છે', 'Should be Gujarati'],
            ['he', 'היי, זה הוא ביטוי עברי', 'Should be Hebrew'],
            ['hi', 'हाय, यह हिन्दी में एक मुहावरा है', 'Should be Hindi'],
            ['hr', 'Bok, ovo je izraz na hrvatskom', 'Should be Croatian'],
            ['hu', 'Bothriechis schlegelii egy mérges kígyó faj található Közép- és Dél-Amerikában. Kicsi és fán, értekezés kígyók caractérisé meg az ő széles skáláját színváltozatban, valamint a szemöldök mérleg át a szemét. Ezek a leggyakoribb a tenyérnyi pitvipers Gyakran és jelen vannak állattani mutat. A pontos neve kitüntetéssel schlegelii német ornitológus, Hermann Schlegel. Nem alfaj Ares jelenleg RECONNU.', 'Should be Hungarian'],
            ['id', 'Hai, ini adalah sebuah kalimat di Indonesia', 'Should be Indonesian'],
            ['it', 'Salve, questo è una frase in italiano', 'Should be Italian'],
            ['i-klingon', 'Qoy qeylIS puqloD', 'Should be Klingon'],
            ['i-klingon', 'tlhIngan mu’qaDmey boghojbogh vIchov vaj cha’leS mu’qaD veS', 'Should be Klingon'],
            ['ja', 'こんにちは、これはスペイン語のフレーズです', 'Should be japanese'],
            ['kn', 'ಹಾಯ್, ಈ ಇಟಾಲಿಯನ್ ಒಂದು ವಾಕ್ಯ', 'Should be Kannada'],
            ['ko', '안녕하세요, 이탈리아의 문장입니다', 'Should be Korean'],
            ['lt', 'Ford LTD Crown Victoria buvo galiniais ratais varomas didelės klasės automobilis, kurį nuo 1983 iki 1991 metų gamino Ford Motor Company. 1992 metais automobilis buvo visiškai atnaujintas ir pavadintas Ford Crown Victoria, tačiau ir toliau buvo gaminamas ant tos pačios Panther platformos.', 'Should be Lithuanian'],
            ['lv', 'Saule ir zvaigzne, kas atrodas Saules sistēmas centrā. Orbītā ap Sauli riņķo Zeme un pārējās Saules sistēmas planētas, kā arī asteroīdi, komētas un citi kosmiskie ķermeņi. Saule ir milzīga plazmas lode, tās masa ir aptuveni 2×1030 kg. Saule sastāv no 74% ūdeņraža un 25% hēlija, pārējo masu veido smagāki elementi (ogleklis, skābeklis, dzelzs u.c.). Saule ir apmēram 4,5—5 miljardus gadu veca, bet vēl pēc 5 miljardiem gadu tā pārvērtīsies par sarkano milzi un tad — par balto punduri (skat. "Zvaigznes evolūcija"). Saule ir Zemei tuvākā un tādējādi arī vislabāk izpētītā zvaigzne.  ', 'Should be Latvian'],
            ['mk', 'Здраво, ова е една фраза на латвиски', 'Should be Macedonian'],
            ['ml', 'ഹായ്, ഈ മലയാളത്തിൽ ഒരു വാചകം ആണ്', 'Should be Malayalam'],
            ['mr', 'हाय, हे मराठी वाक्यांश आहे', 'Should be Marathi'],
            ['ne', 'नमस्ते, यो नेपाली एक वाक्य छ', 'Should be Nepali'],
            ['nl', 'Hoi, dit is een Nederlandse zin', 'Should be Dutch'],
            ['no', 'Johann Friedrich Struensee (1737−1772) var ein dansk-tysk lege og politikar. Han verka som livlege for kong Kristian VII av Danmark-Noreg frå 1769 og var den eigentlege makthavaren i Danmark-Noreg i åra 1770–1772. På grunn av sinnssjukdomen til den regjerande Kristian VII kunne hoffolk som fekk tillit hos kongen i realiteten ta over regjeringsmakta.', 'Should be Norwegian'],
            ['pa', 'ਅਧਿਕਤਮ, ਇਸ ਨੂੰ ਪੰਜਾਬੀ ਵਿਚ ਇਕ ਸ਼ਬਦ ਹੈ', 'Should be Punjabi'],
            ['pl', 'Witam, jest to wyrażenie w języku polskim', 'Should be Polish'],
            ['pt', 'Oi, esta é uma frase em Português', 'Should be Portuguese'],
            ['ro', 'Bună, aceasta este o propoziție în limba română', 'Should be Romanian'],
            ['ru', 'роман российского писателя-фантаста Сергея Лукьяненко, первый по порядку написания и второй по хронологии событий в серии произведений, рассказывающих о вымышленном мире генетически модифицированных людей. Роман был написан в первой половине 1999 года и впервые опубликован в том же году. Вместе с романом «Танцы на снегу» и повестью «Калеки» входит в одноимённый цикл.', 'Should be Russian'],
            ['sk', 'Ahoj, to je slovenské vetu', 'Should be Slovak'],
            ['sl', 'Zdravo, to je slovenski stavek', 'Should be Slovenian'],
            ['sq', 'Hi, ky është një fjali në gjuhën shqipe', 'Should be Albanian'],
            ['sv', 'Hej, detta är ett svenskt mening', 'Should be Swedish'],
            ['sw', 'Hi, hii ni maneno katika Kiswahili', 'Should be Swahili'],
            ['ta', 'Hi, இந்த தமிழ் ஒரு சொற்றொடர் உள்ளது', 'Should be Tamil'],
            ['te', 'హాయ్, ఈ తెలుగులో పదబంధం', 'Should be Telugu'],
            ['th', 'สวัสดีนี่เป็นหนึ่งประโยคในภาษาไทย', 'Should be Thai'],
            ['tl', 'Hi, ito ay isang parirala sa Tagalog', 'Should be Tagalog'],
            ['tr', 'Merhaba, bu Türkçe bir ifade olduğunu', 'Should be Turkish'],
            ['uk', 'Десант на форт Ебен-Емаель — повітряно-десантна операція, проведена німецькими десантниками 10-11 травня 1940 року з метою захоплення стратегічно важливого бельгійського форту Ебен-Емаель і сприяння наземним військам Вермахту на початковій фазі Бельгійської кампанії.', 'Should be Ukrainian'],
            ['ur', 'ہیلو، یہ اردو میں ایک جملہ ہے', 'Should be Urdu'],
            ['vi', 'Hi, đây là một câu trong tiếng Việt', 'Should be Vietnamese'],
            ['zh-cn', '嗨，这是一个中国的句子', 'Should be Chinese (S)'],
            ['zh-tw', '嗨，這是一個中國的句子', 'Should be Chinese (T)'],
        ];
    }

    /**
     * Tests quality of the language detection
     * 
     * @dataProvider getLanguageDetectionScenarios
     */
    public function testDetectionReliability($expected, $string, $message)
    {
        $detector = new LanguageDetector();

        $this->assertEquals(
            $expected,
            $detector->evaluate($string)->getLanguage(),
            $message
        );
    }

    /**
     * Tests quality of the language detection with static calls
     * 
     * @dataProvider getLanguageDetectionScenarios
     */
    public function testStaticDetectionReliability($expected, $string, $message)
    {
        $this->assertEquals(
            $expected,
            LanguageDetector::detect($string),
            $message
        );
    }

    /**
     * Tests __toString()
     */
    public function testToString()
    {
        $this->assertEquals(
            'en',
            (new LanguageDetector())->evaluate('My tailor is rich and Alison is in the kitchen with Bob.')
        );

        $this->assertEquals(
            '',
            new LanguageDetector()
        );
    }

    /**
     * getScores() method
     */
    public function testGetScores()
    {
        $detector = (new LanguageDetector())->evaluate('My tailor is rich and Alison is in the kitchen with Bob.');

        // All subsets have been used
        $this->assertEquals(
            count($detector->getSupportedLanguages()),
            count(array_keys($detector->getScores()))
        );

        // getLanguage() returns the best scored subset
        $this->assertEquals(
            $detector->getLanguage(),
            array_keys($detector->getScores())[0]
        );
    }

    /**
     * getText() method
     */
    public function testGetText()
    {
        $text = 'My tailor is rich and Alison is in the kitchen with Bob.';

        $detector = new LanguageDetector();

        // Before evaluation
        $this->assertEquals('', $detector->getText());

        $detector->evaluate($text);

        // After evaluation
        $this->assertEquals(
            $text, 
            $detector->getText()
        );
    }

    /**
     * _Tests _construct() method
     */
    public function testLanguageRestriction()
    {
        $text = 'My tailor is rich and Alison is in the kitchen with Bob.';

        $detector = new LanguageDetector(null, ['da', 'no', 'sv']);

        $detector->evaluate($text);

        // After evaluation
        $this->assertNotEquals(
            'en',
            $detector->getLanguage()
        );

        $detector = new LanguageDetector(null, ['da', 'no', 'sv', 'en']);

        $detector->evaluate($text);

        // After evaluation
        $this->assertEquals(
            'en',
            $detector->getLanguage()
        );
    }

    /**
     * Tests quality of the language detection with static calls and
     * a restriction in tested subsets.
     *
     * - Randomly pick between 5 and 10 subsets
     * - Add the good one
     * 
     * @dataProvider getLanguageDetectionScenarios
     */
    public function testStaticDetectionReliabilityWithRestrictedNumberOfSubsets($expected, $string, $message)
    {
        // Prepare a random set of languages
        $numberOfSubsets = rand(5, 10);
        $allowed = [$expected];

        while (count($allowed) < $numberOfSubsets) {
            $lang = $this->availableLanguages[ array_rand($this->availableLanguages) ];
            if (!in_array($lang, $allowed)) {
                array_push($allowed, $lang);
            }
        }
        sort($allowed);

        $detector = LanguageDetector::detect($string, $allowed);

        // Right language detected
        $this->assertEquals(
            $expected,
            $detector,
            $message
        );

        // Remove not allowed language
        if ($allowed[0] === '') {
            array_shift($allowed);
        }

        // Right dataset
        $this->assertEquals(
            $allowed,
            $detector->getLanguages(),
            $message
        );        
    }
}
