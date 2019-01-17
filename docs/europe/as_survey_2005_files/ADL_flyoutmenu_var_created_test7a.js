var NoOffFirstLineMenus=14;
	// Number of first level items

var LowBgColor='2B7099';		
	// Background color when mouse is not over
var LowSubBgColor='cecece';	
	// Background color when mouse is not over on subs
var HighBgColor='cecece';		
	// Background color when mouse is over
var HighSubBgColor='336699';	
	// Background color when mouse is over on subs
var FontLowColor='FFFFFF';	
	// Font color when mouse is not over
var FontSubLowColor='002244';	
	// Font color subs when mouse is not over
var FontHighColor='336699';	
	// Font color when mouse is over
var FontSubHighColor='FFFFFF';
	// Font color subs when mouse is over
var BorderColor='FFFFFF';	
	// Border color
var BorderSubColor='FFFFFF';
	// Border color for subs

var BorderWidth=0;				// Border width
var BorderBtwnElmnts=0;			// Border between elements 1 or 0
var FontFamily='Verdana,Arial,Helvetica, sans-serif'
//var FontFamily='<span class="BK10B">'    //modified by patrick
//var spantype = 'red10'
	// Font family menu items
var FontSize=10;
	// Font size menu items
var FontBold=1;					// Bold menu items 1 or 0
var FontItalic=0;				// Italic menu items 1 or 0

var MenuTextCentered='left';	// Item text position 'left', 'center' or 'right'
var MenuCentered='left';		// Menu horizontal position 'left', 'center' or 'right'
var MenuVerticalCentered='top';	// Menu vertical position 'top', 'middle','bottom' or static

var ChildOverlap=.15;			// horizontal overlap child/ parent -- originally -.0
var ChildVerticalOverlap=.6;	// vertical overlap child/ parent --- originally .0

var StartTop=170;				// Menu offset x coordinate
var StartLeft=0;				// Menu offset y coordinate
var VerCorrect=0;				// Multiple frames y correction
var HorCorrect=0;				// Multiple frames x correction
var LeftPaddng=5;				// Left padding
var TopPaddng=5;				// Top padding

var FirstLineHorizontal=0;		// SET TO 1 FOR HORIZONTAL MENU, 0 FOR VERTICAL
var MenuFramesVertical=1;		// Frames in cols or rows 1 or 0

var DissapearDelay=500;		// delay before menu folds in

var TakeOverBgColor=1;			// Menu frame takes over background color subitem frame
var FirstLineFrame='navig';		// Frame where first level appears
var SecLineFrame='space';		// Frame where sub levels appear
var DocTargetFrame='space';		// Frame where target documents appear
var TargetLoc='';				// span id for relative positioning

var HideTop=0;					// Hide first level when loading new document 1 or 0
var MenuWrap=1;					// enables/ disables menu wrap 1 or 0
var RightToLeft=0;				// enables/ disables right to left unfold 1 or 0
var UnfoldsOnClick=0;			// Level 1 unfolds onclick/ onmouseover
var WebMasterCheck=0;			// menu tree checking on or off 1 or 0
var ShowArrow=1;				// Uses arrow gifs when 1
var KeepHilite=1;				// Keep selected path highligthed
var Arrws=['/nav_graphics/spacer.gif',1,1,'/nav_graphics/spacer.gif',1,1,'/nav_graphics/spacer.gif',1,1];
		// Arrow source, width and height

function BeforeStart(){return}
function AfterBuild(){return}
function BeforeFirstOpen(){return}
function AfterCloseAll(){return}

// Menu tree
//	MenuX=new Array(Text to show, Link, background image (optional), number of sub elements, height, width);
//	For rollover images set 'Text to show' to:  'rollover:Image1.jpg:Image2.jpg'

Menu1=new Array("ANTI-SEMITISM","","",3,24,138);
Menu1_2=new Array("Arab World","/main_arab_world/","",0,18,180);
Menu1_1=new Array("International","/main_anti_semitism_International","",0,18,180);
//Menu1_2=new Array("Global Anti-Semitism Home Page","/main_anti_semitism.asp","",0,18,180);
Menu1_3=new Array("United States","/anti_semitism_domestic/","",0,18,180);

Menu2=new Array("CIVIL RIGHTS","/civil_rights","",2,24,180);
Menu2_1=new Array("Civil Rights Front Page","/civil_rights","",0,18,180);
Menu2_2=new Array("ADL Friend of Court Briefs","/civil_rights/ab","",0,18,180);

Menu3=new Array("COMBATING HATE","/combating_hate","",3,24,180);
Menu3_1=new Array("Combating Hate Front Page","/combating_hate","",0,18,180);
Menu3_2=new Array("Hate Crimes Laws","javascript:openWindow('/learn/hate_crimes_laws/map_frameset.html',650,465)","",0,18,180);
Menu3_3=new Array("Hate Symbols Database","/hate_symbols/","",0,18,180);

Menu4=new Array("EDUCATION","/education","",9,24,200);
Menu4_1=new Array("Education Front Page","/education","",0,18,200);
Menu4_2=new Array("A WORLD OF DIFFERENCE®","/a_world_of_difference","",0,18,200);
Menu4_3=new Array("Miller Early Childhood Initiative","/education/miller","",0,18,200);
Menu4_4=new Array("Campus/Higher Education","/education/default_campus.asp","",0,18,200);
Menu4_5=new Array("Children's Bibliography","/bibliography","",0,18,200);
Menu4_6=new Array("Curriculum Connections","/education/curriculum_connections/","",0,18,200);
Menu4_7=new Array("Combating Anti-Semitism ","/education/combat/default_combat_as.asp","",0,18,200);
Menu4_8=new Array("Education Advocacy","/education/default_advocacy.asp","",0,18,200);
Menu4_9=new Array("Special Campaigns/Initiatives","/education/default.asp#init","",0,18,200);

Menu5=new Array("EXTREMISM","/main_Extremism","",5,24,180);
Menu5_1=new Array("Extremism Front Page","/main_Extremism","",0,18,180);
Menu5_2=new Array("Extremism in America","/learn/ext_us/","",0,18,160);
Menu5_3=new Array("Nation of Islam","/nation_of_islam/","",0,18,160);
Menu5_4=new Array("Terrorism Update","/Terror/tu/tu_current.asp","",0,18,200);
Menu5_5=new Array("Upcoming Extremist Events","/learn/Events_2001/events_2003_flashmap.asp","",0,18,180);


Menu6=new Array("HOLOCAUST","/holocaust","",4,24,138);
Menu6_1=new Array("Holocaust Front Page","/holocaust","",0,18,200);
Menu6_2=new Array("Holocaust Education Front Page","/education/edu_holocaust/default_holocaust.asp","",0,18,200);
Menu6_3=new Array("Echoes and Reflections","http://www.echoesandreflections.org","",0,18,200);
Menu6_4=new Array("Dimensions: Holocaust Studies","/dimensions/default.asp","",0,18,200);

Menu7=new Array("INTERFAITH","/interfaith","",0,24,180);

Menu8=new Array("INTERNATIONAL AFFAIRS","/international_affairs","",2,35,180);
Menu8_1=new Array("International Affairs Home Page","/international_affairs","",0,18,200);
Menu8_2=new Array("ADL and OSCE","/osce/","",0,18,200);

Menu9=new Array("INTERNET RUMORS","/internet_rumors","",0,24,180);

Menu10=new Array("ISRAEL","/israel","",5,24,138);
Menu10_1=new Array("Israel Front Page ","/israel","",0,18,180);
Menu10_2=new Array("Advocating for Israel","/israel/advocacy/","",0,18,180);
Menu10_3=new Array("Chronology of Terror Attacks","/Israel/israel_attacks.asp","",0,18,180);
Menu10_4=new Array("Anti-Israel Protest Calendar","http://www.adl.org/main_israel/anti-israel-protests_2005.asp","",0,18,180);
Menu10_5=new Array("ADL Israel Office","http://www.adl.org/adl_israel","",0,18,180);

Menu11=new Array("LAW ENFORCEMENT (L.E.A.R.N.)","/learn","",6,35,138);
Menu11_1=new Array("L.E.A.R.N. Front Page ","/learn","",0,18,180);
Menu11_2=new Array("Law Enforcement Training","/learn/adl_law_enforcement/default.htm?LEARN_Cat=Training&LEARN_SubCat=Training_News","",0,18,160);
Menu11_3=new Array("Extremism in the News","/learn/extremism_in_the_news/Learn_Breaking_News.htm?LEARN_Cat=Extremism&LEARN_SubCat=Extremism_in_the_News","",0,18,160);
Menu11_4=new Array("Upcoming Extremist Events","/learn/Events_2001/events_2003_flashmap.asp?LEARN_Cat=Extremism&LEARN_SubCat=Upcoming_Extremist_Events","",0,18,180);
Menu11_5=new Array("Extremism in America","/learn/ext_us/default.asp?LEARN_Cat=Extremism&LEARN_SubCat=Extremism_in_America","",0,18,160);
Menu11_6=new Array("Officer Safety Information","/learn/safety/","",0,18,180);


Menu12=new Array("RELIGIOUS FREEDOM","/religious_freedom","",5,24,138);
Menu12_1=new Array("Religious Freedom Front Page ","/religious_freedom","",0,18,190);
Menu12_2=new Array("Workplace and Religion","/issue_religious_freedom/religious_ac/accommodation_QA.asp","",0,18,190);
Menu12_3=new Array("Religious Holidays in Classrooms","/issue_education/december_dilemma2.asp","",0,18,190);
Menu12_4=new Array("Creationism","/issue_religious_freedom/create/creationism2.asp","",0,18,190);
Menu12_5=new Array("The Ten Commandments","/10comm/intro.asp","",0,18,190);

Menu13=new Array("SECURITY AWARENESS","/security","",0,35,138);



Menu14=new Array("TERRORISM","/terrorism/","",4,24,138);
Menu14_1=new Array("Terrorism Front Page ","/main_Terrorism","",0,18,200);
Menu14_2=new Array("International Terrorist Symbols","/terrorism/symbols/default.asp","",0,18,200);
Menu14_3=new Array("Domestic Terrorism","http://www.adl.org/learn/default.htm","",0,18,200);
Menu14_4=new Array("Terrorism Update Archive","terrorism/terrorism_update_archive.asp","",0,18,200);