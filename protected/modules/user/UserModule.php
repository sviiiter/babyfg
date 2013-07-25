<?php
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.googlecode.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 105 2011-02-16 13:05:56Z mishamx $
 */

class UserModule extends CWebModule
{
	/**
	 * @var int
	 * @desc items on page
	 */
	public $user_page_size = 10;
	
	/**
	 * @var int
	 * @desc items on page
	 */
	public $fields_page_size = 10;
	
	/**
	 * @var string
	 * @desc hash method (md5,sha1 or algo hash function http://www.php.net/manual/en/function.hash.php)
	 */
	public $hash='md5';
	
	/**
	 * @var boolean
	 * @desc use email for activation user account
	 */
	public $sendActivationMail=true;
	
	/**
	 * @var boolean
	 * @desc allow auth for is not active user
	 */
	public $loginNotActiv=false;
	
	/**
	 * @var boolean
	 * @desc activate user on registration (only $sendActivationMail = false)
	 */
	public $activeAfterRegister=false;
	
	/**
	 * @var boolean
	 * @desc login after registration (need loginNotActiv or activeAfterRegister = true)
	 */
	public $autoLogin=true;
	
	public $registrationUrl = array("/registration");
	public $recoveryUrl = array("/recovery");
	public $loginUrl = array("/login");
	public $logoutUrl = array("/logout");
	public $profileUrl = array("/user/profile");
	public $returnUrl = array("/user/profile");
	public $returnLogoutUrl = array("/login");
	
	public $fieldsMessage = '';
	
	/**
	 * @var array
	 * @desc User model relation from other models
	 * @see http://www.yiiframework.com/doc/guide/database.arr
	 */
	public $relations = array();
	
	/**
	 * @var array
	 * @desc Profile model relation from other models
	 */
	public $profileRelations = array();
	
	/**
	 * @var boolean
	 */
	public $captcha = array('registration'=>true);
	
	/**
	 * @var boolean
	 */
	//public $cacheEnable = false;
	
	public $tableUsers = '{{users}}';
	public $tableProfiles = '{{profiles}}';
	public $tableProfileFields = '{{profiles_fields}}';
	
	static private $_user;
	static private $_admin;
	static private $_admins;
	
	/**
	 * @var array
	 * @desc Behaviors for models
	 */
	public $componentBehaviors=array();
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));
	}
	
	public function getBehaviorsFor($componentName){
        if (isset($this->componentBehaviors[$componentName])) {
            return $this->componentBehaviors[$componentName];
        } else {
            return array();
        }
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='',$params=array(),$dic='user') {
		return Yii::t("UserModule.".$dic, $str, $params);
	}
	
	/**
	 * @return hash string.
	 */
	public static function encrypting($string="") {
		$hash = Yii::app()->getModule('user')->hash;
		if ($hash=="md5")
			return md5($string);
		if ($hash=="sha1")
			return sha1($string);
		else
			return hash($hash,$string);
	}
	
	/**
	 * @param $place
	 * @return boolean 
	 */
	public static function doCaptcha($place = '') {
		if(!extension_loaded('gd'))
			return false;
		if (in_array($place, Yii::app()->getModule('user')->captcha))
			return Yii::app()->getModule('user')->captcha[$place];
		return false;
	}
	
	/**
	 * Return admin status.
	 * @return boolean
	 */
	public static function isAdmin() {
		if(Yii::app()->user->isGuest)
			return false;
		else {
			if (!isset(self::$_admin)) {
				if(self::user()->superuser)
					self::$_admin = true;
				else
					self::$_admin = false;	
			}
			return self::$_admin;
		}
	}

	/**
	 * Return admins.
	 * @return array syperusers names
	 */	
	public static function getAdmins() {
		if (!self::$_admins) {
			$admins = User::model()->active()->superuser()->findAll();
			$return_name = array();
			foreach ($admins as $admin)
				array_push($return_name,$admin->username);
			self::$_admins = $return_name;
		}
		return self::$_admins;
	}
	
	/**
	 * Send mail method
	 */
	public static function sendMail($email,$subject,$message) {
    	$adminEmail = Yii::app()->params['adminEmail'];
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
	    return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
	
	/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public static function user($id=0) {
		if ($id) 
			return User::model()->active()->findbyPk($id);
		else {
			if(Yii::app()->user->isGuest) {
				return false;
			} else {
				if (!self::$_user)
					self::$_user = User::model()->active()->findbyPk(Yii::app()->user->id);
				return self::$_user;
			}
		}
	}
	
	/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public function users() {
		return User;
	}
     
        
    public static function generatePassword($number)
    {
        //$arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0',
        $arrNumber = array('1','2','3','4','5','6','7','8','9','0');
        $arr = array("a",     "abe",   "ace",   "act",   "ad",    "ada",   "add",
        "ago",   "aid",   "aim",   "air",   "all",   "alp",   "am",    "amy",
        "an",    "ana",   "and",   "ann",   "ant",   "any",   "ape",   "aps",
        "apt",   "arc",   "are",   "ark",   "arm",   "art",   "as",    "ash",
        "ask",   "at",    "ate",   "aug",   "auk",   "ave",   "awe",   "awk",
        "awl",   "awn",   "ax",    "aye",   "bad",   "bag",   "bah",   "bam",
        "ban",   "bar",   "bat",   "bay",   "be",    "bed",   "bee",   "beg",
        "ben",   "bet",   "bey",   "bib",   "bid",   "big",   "bin",   "bit",
        "bob",   "bog",   "bon",   "boo",   "bop",   "bow",   "boy",   "bub",
        "bud",   "bug",   "bum",   "bun",   "bus",   "but",   "buy",   "by",
        "bye",   "cab",   "cal",   "cam",   "can",   "cap",   "car",   "cat",
        "caw",   "cod",   "cog",   "col",   "con",   "coo",   "cop",   "cot",
        "cow",   "coy",   "cry",   "cub",   "cue",   "cup",   "cur",   "cut",
        "dab",   "dad",   "dam",   "dan",   "dar",   "day",   "dee",   "del",
        "den",   "des",   "dew",   "did",   "die",   "dig",   "din",   "dip",
        "do",    "doe",   "dog",   "don",   "dot",   "dow",   "dry",   "dub",
        "dud",   "due",   "dug",   "dun",   "ear",   "eat",   "ed",    "eel",
        "egg",   "ego",   "eli",   "elk",   "elm",   "ely",   "em",    "end",
        "est",   "etc",   "eva",   "eve",   "ewe",   "eye",   "fad",   "fan",
        "far",   "fat",   "fay",   "fed",   "fee",   "few",   "fib",   "fig",
        "fin",   "fir",   "fit",   "flo",   "fly",   "foe",   "fog",   "for",
        "fry",   "fum",   "fun",   "fur",   "gab",   "gad",   "gag",   "gal",
        "gam",   "gap",   "gas",   "gay",   "gee",   "gel",   "gem",   "get",
        "gig",   "gil",   "gin",   "go",    "got",   "gum",   "gun",   "gus",
        "gut",   "guy",   "gym",   "gyp",   "ha",    "had",   "hal",   "ham",
        "han",   "hap",   "has",   "hat",   "haw",   "hay",   "he",    "hem",
        "hen",   "her",   "hew",   "hey",   "hi",    "hid",   "him",   "hip",
        "his",   "hit",   "ho",    "hob",   "hoc",   "hoe",   "hog",   "hop",
        "hot",   "how",   "hub",   "hue",   "hug",   "huh",   "hum",   "hut",
        "i",     "icy",   "ida",   "if",    "ike",   "ill",   "ink",   "inn",
        "io",    "ion",   "iq",    "ira",   "ire",   "irk",   "is",    "it",
        "its",   "ivy",   "jab",   "jag",   "jam",   "jan",   "jar",   "jaw",
        "jay",   "jet",   "jig",   "jim",   "jo",    "job",   "joe",   "jog",
        "jot",   "joy",   "jug",   "jut",   "kay",   "keg",   "ken",   "key",
        "kid",   "kim",   "kin",   "kit",   "la",    "lab",   "lac",   "lad",
        "lag",   "lam",   "lap",   "law",   "lay",   "lea",   "led",   "lee",
        "leg",   "len",   "leo",   "let",   "lew",   "lid",   "lie",   "lin",
        "lip",   "lit",   "lo",    "lob",   "log",   "lop",   "los",   "lot",
        "lou",   "low",   "loy",   "lug",   "lye",   "ma",    "mac",   "mad",
        "mae",   "man",   "mao",   "map",   "mat",   "maw",   "may",   "me",
        "meg",   "mel",   "men",   "met",   "mew",   "mid",   "min",   "mit",
        "mob",   "mod",   "moe",   "moo",   "mop",   "mos",   "mot",   "mow",
        "mud",   "mug",   "mum",   "my",    "nab",   "nag",   "nan",   "nap",
        "nat",   "nay",   "ne",    "ned",   "nee",   "net",   "new",   "nib",
        "nil",   "nip",   "nit",   "no",    "nob",   "nod",   "non",   "nor",
        "not",   "nov",   "now",   "nu",    "nun",   "nut",   "o",     "oaf",
        "oak",   "oar",   "oat",   "odd",   "ode",   "of",    "off",   "oft",
        "oh",    "oil",   "ok",    "old",   "on",    "one",   "or",    "orb",
        "ore",   "orr",   "os",    "ott",   "our",   "out",   "ova",   "ow",
        "owe",   "owl",   "own",   "ox",    "pa",    "pad",   "pal",   "pam",
        "pan",   "pap",   "par",   "pat",   "paw",   "pay",   "pea",   "peg",
        "pen",   "pep",   "per",   "pet",   "pew",   "phi",   "pi",    "pie",
        "pin",   "pit",   "ply",   "po",    "pod",   "poe",   "pop",   "pot",
        "pow",   "pro",   "pry",   "pub",   "pug",   "pun",   "pup",   "put",
        "quo",   "rag",   "ram",   "ran",   "rap",   "rat",   "raw",   "ray",
        "reb",   "red",   "rep",   "ret",   "rib",   "rid",   "rig",   "rim",
        "rio",   "rip",   "rob",   "rod",   "roe",   "ron",   "rot",   "row",
        "roy",   "rub",   "rue",   "rug",   "rum",   "run",   "rye",   "sac",
        "sad",   "sag",   "sal",   "sam",   "san",   "sap",   "sat",   "saw",
        "say",   "sea",   "sec",   "see",   "sen",   "set",   "sew",   "she",
        "shy",   "sin",   "sip",   "sir",   "sis",   "sit",   "ski",   "sky",
        "sly",   "so",    "sob",   "sod",   "son",   "sop",   "sow",   "soy",
        "spa",   "spy",   "sub",   "sud",   "sue",   "sum",   "sun",   "sup",
        "tab",   "tad",   "tag",   "tan",   "tap",   "tar",   "tea",   "ted",
        "tee",   "ten",   "the",   "thy",   "tic",   "tie",   "tim",   "tin",
        "tip",   "to",    "toe",   "tog",   "tom",   "ton",   "too",   "top",
        "tow",   "toy",   "try",   "tub",   "tug",   "tum",   "tun",   "two",
        "un",    "up",    "us",    "use",   "van",   "vat",   "vet",   "vie",
        "wad",   "wag",   "war",   "was",   "way",   "we",    "web",   "wed",
        "wee",   "wet",   "who",   "why",   "win",   "wit",   "wok",   "won",
        "woo",   "wow",   "wry",   "wu",    "yam",   "yap",   "yaw",   "ye",
        "yea",   "yes",   "yet",   "you",   "abed",  "abel",  "abet",  "able",
        "abut",  "ache",  "acid",  "acme",  "acre",  "acta",  "acts",  "adam",
        "adds",  "aden",  "afar",  "afro",  "agee",  "ahem",  "ahoy",  "aida",
        "aide",  "aids",  "airy",  "ajar",  "akin",  "alan",  "alec",  "alga",
        "alia",  "ally",  "alma",  "aloe",  "also",  "alto",  "alum",  "alva",
        "amen",  "ames",  "amid",  "ammo",  "amok",  "amos",  "amra",  "andy",
        "anew",  "anna",  "anne",  "ante",  "anti",  "aqua",  "arab",  "arch",
        "area",  "argo",  "arid",  "army",  "arts",  "arty",  "asia",  "asks",
        "atom",  "aunt",  "aura",  "auto",  "aver",  "avid",  "avis",  "avon",
        "avow",  "away",  "awry",  "babe",  "baby",  "bach",  "back",  "bade",
        "bail",  "bait",  "bake",  "bald",  "bale",  "bali",  "balk",  "ball",
        "balm",  "band",  "bane",  "bang",  "bank",  "barb",  "bard",  "bare",
        "bark",  "barn",  "barr",  "base",  "bash",  "bask",  "bass",  "bate",
        "bath",  "bawd",  "bawl",  "bead",  "beak",  "beam",  "bean",  "bear",
        "beat",  "beau",  "beck",  "beef",  "been",  "beer",  "beet",  "bela",
        "bell",  "belt",  "bend",  "bent",  "berg",  "bern",  "bert",  "bess",
        "best",  "beta",  "beth",  "bhoy",  "bias",  "bide",  "bien",  "bile",
        "bilk",  "bill",  "bind",  "bing",  "bird",  "bite",  "bits",  "blab",
        "blat",  "bled",  "blew",  "blob",  "bloc",  "blot",  "blow",  "blue",
        "blum",  "blur",  "boar",  "boat",  "boca",  "bock",  "bode",  "body",
        "bogy",  "bohr",  "boil",  "bold",  "bolo",  "bolt",  "bomb",  "bona",
        "bond",  "bone",  "bong",  "bonn",  "bony",  "book",  "boom",  "boon",
        "boot",  "bore",  "borg",  "born",  "bose",  "boss",  "both",  "bout",
        "bowl",  "boyd",  "brad",  "brae",  "brag",  "bran",  "bray",  "bred",
        "brew",  "brig",  "brim",  "brow",  "buck",  "budd",  "buff",  "bulb",
        "bulk",  "bull",  "bunk",  "bunt",  "buoy",  "burg",  "burl",  "burn",
        "burr",  "burt",  "bury",  "bush",  "buss",  "bust",  "busy",  "byte",
        "cady",  "cafe",  "cage",  "cain",  "cake",  "calf",  "call",  "calm",
        "came",  "cane",  "cant",  "card",  "care",  "carl",  "carr",  "cart",
        "case",  "cash",  "cask",  "cast",  "cave",  "ceil",  "cell",  "cent",
        "cern",  "chad",  "char",  "chat",  "chaw",  "chef",  "chen",  "chew",
        "chic",  "chin",  "chou",  "chow",  "chub",  "chug",  "chum",  "cite",
        "city",  "clad",  "clam",  "clan",  "claw",  "clay",  "clod",  "clog",
        "clot",  "club",  "clue",  "coal",  "coat",  "coca",  "cock",  "coco",
        "coda",  "code",  "cody",  "coed",  "coil",  "coin",  "coke",  "cola",
        "cold",  "colt",  "coma",  "comb",  "come",  "cook",  "cool",  "coon",
        "coot",  "cord",  "core",  "cork",  "corn",  "cost",  "cove",  "cowl",
        "crab",  "crag",  "cram",  "cray",  "crew",  "crib",  "crow",  "crud",
        "cuba",  "cube",  "cuff",  "cull",  "cult",  "cuny",  "curb",  "curd",
        "cure",  "curl",  "curt",  "cuts",  "dade",  "dale",  "dame",  "dana",
        "dane",  "dang",  "dank",  "dare",  "dark",  "darn",  "dart",  "dash",
        "data",  "date",  "dave",  "davy",  "dawn",  "days",  "dead",  "deaf",
        "deal",  "dean",  "dear",  "debt",  "deck",  "deed",  "deem",  "deer",
        "deft",  "defy",  "dell",  "dent",  "deny",  "desk",  "dial",  "dice",
        "died",  "diet",  "dime",  "dine",  "ding",  "dint",  "dire",  "dirt",
        "disc",  "dish",  "disk",  "dive",  "dock",  "does",  "dole",  "doll",
        "dolt",  "dome",  "done",  "doom",  "door",  "dora",  "dose",  "dote",
        "doug",  "dour",  "dove",  "down",  "drab",  "drag",  "dram",  "draw",
        "drew",  "drub",  "drug",  "drum",  "dual",  "duck",  "duct",  "duel",
        "duet",  "duke",  "dull",  "dumb",  "dune",  "dunk",  "dusk",  "dust",
        "duty",  "each",  "earl",  "earn",  "ease",  "east",  "easy",  "eben",
        "echo",  "eddy",  "eden",  "edge",  "edgy",  "edit",  "edna",  "egan",
        "elan",  "elba",  "ella",  "else",  "emil",  "emit",  "emma",  "ends",
        "eric",  "eros",  "even",  "ever",  "evil",  "eyed",  "face",  "fact",
        "fade",  "fail",  "fain",  "fair",  "fake",  "fall",  "fame",  "fang",
        "farm",  "fast",  "fate",  "fawn",  "fear",  "feat",  "feed",  "feel",
        "feet",  "fell",  "felt",  "fend",  "fern",  "fest",  "feud",  "fief",
        "figs",  "file",  "fill",  "film",  "find",  "fine",  "fink",  "fire",
        "firm",  "fish",  "fisk",  "fist",  "fits",  "five",  "flag",  "flak",
        "flam",  "flat",  "flaw",  "flea",  "fled",  "flew",  "flit",  "floc",
        "flog",  "flow",  "flub",  "flue",  "foal",  "foam",  "fogy",  "foil",
        "fold",  "folk",  "fond",  "font",  "food",  "fool",  "foot",  "ford",
        "fore",  "fork",  "form",  "fort",  "foss",  "foul",  "four",  "fowl",
        "frau",  "fray",  "fred",  "free",  "fret",  "frey",  "frog",  "from",
        "fuel",  "full",  "fume",  "fund",  "funk",  "fury",  "fuse",  "fuss",
        "gaff",  "gage",  "gail",  "gain",  "gait",  "gala",  "gale",  "gall",
        "galt",  "game",  "gang",  "garb",  "gary",  "gash",  "gate",  "gaul",
        "gaur",  "gave",  "gawk",  "gear",  "geld",  "gene",  "gent",  "germ",
        "gets",  "gibe",  "gift",  "gild",  "gill",  "gilt",  "gina",  "gird",
        "girl",  "gist",  "give",  "glad",  "glee",  "glen",  "glib",  "glob",
        "glom",  "glow",  "glue",  "glum",  "glut",  "goad",  "goal",  "goat",
        "goer",  "goes",  "gold",  "golf",  "gone",  "gong",  "good",  "goof",
        "gore",  "gory",  "gosh",  "gout",  "gown",  "grab",  "grad",  "gray",
        "greg",  "grew",  "grey",  "grid",  "grim",  "grin",  "grit",  "grow",
        "grub",  "gulf",  "gull",  "gunk",  "guru",  "gush",  "gust",  "gwen",
        "gwyn",  "haag",  "haas",  "hack",  "hail",  "hair",  "hale",  "half",
        "hall",  "halo",  "halt",  "hand",  "hang",  "hank",  "hans",  "hard",
        "hark",  "harm",  "hart",  "hash",  "hast",  "hate",  "hath",  "haul",
        "have",  "hawk",  "hays",  "head",  "heal",  "hear",  "heat",  "hebe",
        "heck",  "heed",  "heel",  "heft",  "held",  "hell",  "helm",  "herb",
        "herd",  "here",  "hero",  "hers",  "hess",  "hewn",  "hick",  "hide",
        "high",  "hike",  "hill",  "hilt",  "hind",  "hint",  "hire",  "hiss",
        "hive",  "hobo",  "hock",  "hoff",  "hold",  "hole",  "holm",  "holt",
        "home",  "hone",  "honk",  "hood",  "hoof",  "hook",  "hoot",  "horn",
        "hose",  "host",  "hour",  "hove",  "howe",  "howl",  "hoyt",  "huck",
        "hued",  "huff",  "huge",  "hugh",  "hugo",  "hulk",  "hull",  "hunk",
        "hunt",  "hurd",  "hurl",  "hurt",  "hush",  "hyde",  "hymn",  "ibis",
        "icon",  "idea",  "idle",  "iffy",  "inca",  "inch",  "into",  "ions",
        "iota",  "iowa",  "iris",  "irma",  "iron",  "isle",  "itch",  "item",
        "ivan",  "jack",  "jade",  "jail",  "jake",  "jane",  "java",  "jean",
        "jeff",  "jerk",  "jess",  "jest",  "jibe",  "jill",  "jilt",  "jive",
        "joan",  "jobs",  "jock",  "joel",  "joey",  "john",  "join",  "joke",
        "jolt",  "jove",  "judd",  "jude",  "judo",  "judy",  "juju",  "juke",
        "july",  "june",  "junk",  "juno",  "jury",  "just",  "jute",  "kahn",
        "kale",  "kane",  "kant",  "karl",  "kate",  "keel",  "keen",  "keno",
        "kent",  "kern",  "kerr",  "keys",  "kick",  "kill",  "kind",  "king",
        "kirk",  "kiss",  "kite",  "klan",  "knee",  "knew",  "knit",  "knob",
        "knot",  "know",  "koch",  "kong",  "kudo",  "kurd",  "kurt",  "kyle",
        "lace",  "lack",  "lacy",  "lady",  "laid",  "lain",  "lair",  "lake",
        "lamb",  "lame",  "land",  "lane",  "lang",  "lard",  "lark",  "lass",
        "last",  "late",  "laud",  "lava",  "lawn",  "laws",  "lays",  "lead",
        "leaf",  "leak",  "lean",  "lear",  "leek",  "leer",  "left",  "lend",
        "lens",  "lent",  "leon",  "lesk",  "less",  "lest",  "lets",  "liar",
        "lice",  "lick",  "lied",  "lien",  "lies",  "lieu",  "life",  "lift",
        "like",  "lila",  "lilt",  "lily",  "lima",  "limb",  "lime",  "lind",
        "line",  "link",  "lint",  "lion",  "lisa",  "list",  "live",  "load",
        "loaf",  "loam",  "loan",  "lock",  "loft",  "loge",  "lois",  "lola",
        "lone",  "long",  "look",  "loon",  "loot",  "lord",  "lore",  "lose",
        "loss",  "lost",  "loud",  "love",  "lowe",  "luck",  "lucy",  "luge",
        "luke",  "lulu",  "lund",  "lung",  "lura",  "lure",  "lurk",  "lush",
        "lust",  "lyle",  "lynn",  "lyon",  "lyra",  "mace",  "made",  "magi",
        "maid",  "mail",  "main",  "make",  "male",  "mali",  "mall",  "malt",
        "mana",  "mann",  "many",  "marc",  "mare",  "mark",  "mars",  "mart",
        "mary",  "mash",  "mask",  "mass",  "mast",  "mate",  "math",  "maul",
        "mayo",  "mead",  "meal",  "mean",  "meat",  "meek",  "meet",  "meld",
        "melt",  "memo",  "mend",  "menu",  "mert",  "mesh",  "mess",  "mice",
        "mike",  "mild",  "mile",  "milk",  "mill",  "milt",  "mimi",  "mind",
        "mine",  "mini",  "mink",  "mint",  "mire",  "miss",  "mist",  "mite",
        "mitt",  "moan",  "moat",  "mock",  "mode",  "mold",  "mole",  "moll",
        "molt",  "mona",  "monk",  "mont",  "mood",  "moon",  "moor",  "moot",
        "more",  "morn",  "mort",  "moss",  "most",  "moth",  "move",  "much",
        "muck",  "mudd",  "muff",  "mule",  "mull",  "murk",  "mush",  "must",
        "mute",  "mutt",  "myra",  "myth",  "nagy",  "nail",  "nair",  "name",
        "nary",  "nash",  "nave",  "navy",  "neal",  "near",  "neat",  "neck",
        "need",  "neil",  "nell",  "neon",  "nero",  "ness",  "nest",  "news",
        "newt",  "nibs",  "nice",  "nick",  "nile",  "nina",  "nine",  "noah",
        "node",  "noel",  "noll",  "none",  "nook",  "noon",  "norm",  "nose",
        "note",  "noun",  "nova",  "nude",  "null",  "numb",  "oath",  "obey",
        "oboe",  "odin",  "ohio",  "oily",  "oint",  "okay",  "olaf",  "oldy",
        "olga",  "olin",  "oman",  "omen",  "omit",  "once",  "ones",  "only",
        "onto",  "onus",  "oral",  "orgy",  "oslo",  "otis",  "otto",  "ouch",
        "oust",  "outs",  "oval",  "oven",  "over",  "owly",  "owns",  "quad",
        "quit",  "quod",  "race",  "rack",  "racy",  "raft",  "rage",  "raid",
        "rail",  "rain",  "rake",  "rank",  "rant",  "rare",  "rash",  "rate",
        "rave",  "rays",  "read",  "real",  "ream",  "rear",  "reck",  "reed",
        "reef",  "reek",  "reel",  "reid",  "rein",  "rena",  "rend",  "rent",
        "rest",  "rice",  "rich",  "rick",  "ride",  "rift",  "rill",  "rime",
        "ring",  "rink",  "rise",  "risk",  "rite",  "road",  "roam",  "roar",
        "robe",  "rock",  "rode",  "roil",  "roll",  "rome",  "rood",  "roof",
        "rook",  "room",  "root",  "rosa",  "rose",  "ross",  "rosy",  "roth",
        "rout",  "rove",  "rowe",  "rows",  "rube",  "ruby",  "rude",  "rudy",
        "ruin",  "rule",  "rung",  "runs",  "runt",  "ruse",  "rush",  "rusk",
        "russ",  "rust",  "ruth",  "sack",  "safe",  "sage",  "said",  "sail",
        "sale",  "salk",  "salt",  "same",  "sand",  "sane",  "sang",  "sank",
        "sara",  "saul",  "save",  "says",  "scan",  "scar",  "scat",  "scot",
        "seal",  "seam",  "sear",  "seat",  "seed",  "seek",  "seem",  "seen",
        "sees",  "self",  "sell",  "send",  "sent",  "sets",  "sewn",  "shag",
        "sham",  "shaw",  "shay",  "shed",  "shim",  "shin",  "shod",  "shoe",
        "shot",  "show",  "shun",  "shut",  "sick",  "side",  "sift",  "sigh",
        "sign",  "silk",  "sill",  "silo",  "silt",  "sine",  "sing",  "sink",
        "sire",  "site",  "sits",  "situ",  "skat",  "skew",  "skid",  "skim",
        "skin",  "skit",  "slab",  "slam",  "slat",  "slay",  "sled",  "slew",
        "slid",  "slim",  "slit",  "slob",  "slog",  "slot",  "slow",  "slug",
        "slum",  "slur",  "smog",  "smug",  "snag",  "snob",  "snow",  "snub",
        "snug",  "soak",  "soar",  "sock",  "soda",  "sofa",  "soft",  "soil",
        "sold",  "some",  "song",  "soon",  "soot",  "sore",  "sort",  "soul",
        "sour",  "sown",  "stab",  "stag",  "stan",  "star",  "stay",  "stem",
        "stew",  "stir",  "stow",  "stub",  "stun",  "such",  "suds",  "suit",
        "sulk",  "sums",  "sung",  "sunk",  "sure",  "surf",  "swab",  "swag",
        "swam",  "swan",  "swat",  "sway",  "swim",  "swum",  "tack",  "tact",
        "tail",  "take",  "tale",  "talk",  "tall",  "tank",  "task",  "tate",
        "taut",  "teal",  "team",  "tear",  "tech",  "teem",  "teen",  "teet",
        "tell",  "tend",  "tent",  "term",  "tern",  "tess",  "test",  "than",
        "that",  "thee",  "them",  "then",  "they",  "thin",  "this",  "thud",
        "thug",  "tick",  "tide",  "tidy",  "tied",  "tier",  "tile",  "till",
        "tilt",  "time",  "tina",  "tine",  "tint",  "tiny",  "tire",  "toad",
        "togo",  "toil",  "told",  "toll",  "tone",  "tong",  "tony",  "took",
        "tool",  "toot",  "tore",  "torn",  "tote",  "tour",  "tout",  "town",
        "trag",  "tram",  "tray",  "tree",  "trek",  "trig",  "trim",  "trio",
        "trod",  "trot",  "troy",  "true",  "tuba",  "tube",  "tuck",  "tuft",
        "tuna",  "tune",  "tung",  "turf",  "turn",  "tusk",  "twig",  "twin",
        "twit",  "ulan",  "unit",  "urge",  "used",  "user",  "uses",  "utah",
        "vail",  "vain",  "vale",  "vary",  "vase",  "vast",  "veal",  "veda",
        "veil",  "vein",  "vend",  "vent",  "verb",  "very",  "veto",  "vice",
        "view",  "vine",  "vise",  "void",  "volt",  "vote",  "wack",  "wade",
        "wage",  "wail",  "wait",  "wake",  "wale",  "walk",  "wall",  "walt",
        "wand",  "wane",  "wang",  "want",  "ward",  "warm",  "warn",  "wart",
        "wash",  "wast",  "wats",  "watt",  "wave",  "wavy",  "ways",  "weak",
        "weal",  "wean",  "wear",  "weed",  "week",  "weir",  "weld",  "well",
        "welt",  "went",  "were",  "wert",  "west",  "wham",  "what",  "whee",
        "when",  "whet",  "whoa",  "whom",  "wick",  "wife",  "wild",  "will",
        "wind",  "wine",  "wing",  "wink",  "wino",  "wire",  "wise",  "wish",
        "with",  "wolf",  "wont",  "wood",  "wool",  "word",  "wore",  "work",
        "worm",  "worn",  "wove",  "writ",  "wynn",  "yale",  "yang",  "yank",
        "yard",  "yarn",  "yawl",  "yawn",  "yeah",  "year",  "yell",  "yoga",
        "yoke"   );
		// Генерируем пароль
		$pass = "";
		$param=count($arr) - 1;
                $i = 0;
		while($i < $number)
		{
			// Вычисляем случайный индекс массива
                        if($i > 0){
                            $pass .= $arrNumber[rand(0,  count($arrNumber) - 1)];
                        }
			$index = rand(0, $param);
			$pass .= $arr[$index];
			$i = strlen($pass);
		}
		return $pass;
    }        
        
}
