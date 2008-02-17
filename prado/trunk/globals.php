<?php
// MODIFY THIS FILE FOR LOCAL CONFIGURATION

$ABS_PATH = "/Users/mkatsenes/Sites/workspace/prado-gcode";
$USERS_PREFIX = "protected/users";

$PERSEUS_SERVER="http://www.tiro-interactive.org/hopper/";
$PERSEUS_TEXT_DIR="/Users/mkatsenes/Sites/perseus-texts/";

// Massive Hard-coded arrays
	 $AUTHOR_ARRAY = Array("Plautus","Terence","Caesar",
		"Catullus","Cicero","Cornelius Nepos","Sulpicia","Vergil",
		"Horace","Livy","Lucan","Lucretius","Ovid",
		"Phaedrus","Pliny the Elder","Vitruvius","Augustus",
		"Pliny the Younger","Suetonius","Servius","Sallust",
		"New Testament","Old Testament","Boethius");
	
	$TEXT_ARRAY = Array(
		"Plautus" => Array(
			Array("perseus" => "Perseus:text:1999.02.0030", "title" => "Amphitruo"),
			Array("perseus" => "Perseus:text:1999.02.0031", "title" => "Asinaria"),
			Array("perseus" => "Perseus:text:1999.02.0032", "title" => "Aulularia"),
			Array("perseus" => "Perseus:text:1999.02.0033", "title" => "Bacchides"),
			Array("perseus" => "Perseus:text:1999.02.0034", "title" => "Captivi"),
			Array("perseus" => "Perseus:text:1999.02.0035", "title" => "Casina"),
			Array("perseus" => "Perseus:text:1999.02.0036", "title" => "Cistellaria"),
			Array("perseus" => "Perseus:text:1999.02.0037", "title" => "Curculio"),
			Array("perseus" => "Perseus:text:1999.02.0038", "title" => "Epidicus"),
			Array("perseus" => "Perseus:text:1999.02.0039", "title" => "Menaechmi"),
			Array("perseus" => "Perseus:text:1999.02.0040", "title" => "Mercator"),
			Array("perseus" => "Perseus:text:1999.02.0041", "title" => "Miles Gloriosus"),
			Array("perseus" => "Perseus:text:1999.02.0042", "title" => "Mostellaria"),
			Array("perseus" => "Perseus:text:1999.02.0043", "title" => "Persa"),
			Array("perseus" => "Perseus:text:1999.02.0044", "title" => "Poenulus"),
			Array("perseus" => "Perseus:text:1999.02.0045", "title" => "Pseudolus"),
			Array("perseus" => "Perseus:text:1999.02.0046", "title" => "Rudens"),
			Array("perseus" => "Perseus:text:1999.02.0047", "title" => "Stichus"),
			Array("perseus" => "Perseus:text:1999.02.0048", "title" => "Trinummus"),
			Array("perseus" => "Perseus:text:1999.02.0049", "title" => "Truculentus")
		),
		"Terence" => Array(
Array("perseus" => "Perseus:text:1999.02.0087", "title" => "Andria"),
Array("perseus" => "Perseus:text:1999.02.0089", "title" => "The Self-Tormenter"),
Array("perseus" => "Perseus:text:1999.02.0088", "title" => "The Eunuch"),
Array("perseus" => "Perseus:text:1999.02.0091", "title" => "Phormio"),
Array("perseus" => "Perseus:text:1999.02.0090", "title" => "The Mother-in-Law"),
Array("perseus" => "Perseus:text:1999.02.0086", "title" => "The Brothers")
		),
		"Caesar" => Array (
Array("perseus" => "Perseus:text:1999.02.0002", "title" => "Gallic War"),
Array("perseus" => "Perseus:text:1999.02.0075", "title" => "Civil War")
		),
		"Catullus" => Array (
Array("perseus" => "Perseus:text:1999.02.0003", "title" => "Poems")
		),
		"Cicero" => Array (
Array("perseus" => "Perseus:text:1999.02.0013:text=Quinct.", "title" => "For Publius Quinctius"),
Array("perseus" => "Perseus:text:1999.02.0010:text=S. Rosc.", "title" => "For Sextus Roscius of Ameria"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Q. Rosc.", "title" => "For Quintus Roscius the Actor"),
Array("perseus" => "Perseus:text:1999.02.0012:text=Div. Caec.", "title" => "Divinatio against Q. Caecilius"),
Array("perseus" => "Perseus:text:1999.02.0012:text=Ver.", "title" => "Against Verres"),
Array("perseus" => "Perseus:text:1999.02.0015:text=Tul.", "title" => "For Marcus Tullius"),
Array("perseus" => "Perseus:text:1999.02.0015:text=Font.", "title" => "For Marcus Fonteius"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Caec.", "title" => "For Aulus Caecina"),
Array("perseus" => "Perseus:text:1999.02.0010:text=Man.", "title" => "On Pompey's Command"),
Array("perseus" => "Perseus:text:1999.02.0010:text=Clu.", "title" => "For Aulus Cluentius"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Agr.", "title" => "On the Agrarian Law"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Rab. Perd.", "title" => "For Rabirius on a Charge of Treason"),
Array("perseus" => "Perseus:text:1999.02.0010:text=Catil.", "title" => "Against Catiline"),
Array("perseus" => "Perseus:text:1999.02.0010:text=Mur.", "title" => "For Lucius Murena"),
Array("perseus" => "Perseus:text:1999.02.0015:text=Sul.", "title" => "For Sulla"),
Array("perseus" => "Perseus:text:1999.02.0015:text=Arch.", "title" => "For Archias"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Flac.", "title" => "For Flaccus"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Red. Pop.", "title" => "To the Citizens after his Return"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Red. Sen.", "title" => "In the Senate after his Return"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Dom.", "title" => "On his House"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Har.", "title" => "On the Responses of the Haruspices"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Sest.", "title" => "For Sestius"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Vat.", "title" => "Against Vatinius"),
Array("perseus" => "Perseus:text:1999.02.0010:text=Cael.", "title" => "For Marcus Caelius"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Prov.", "title" => "On the Consular Provinces"),
Array("perseus" => "Perseus:text:1999.02.0014:text=Balb.", "title" => "For Cornelius Balbus"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Pis.", "title" => "Against Piso"),
Array("perseus" => "Perseus:text:1999.02.0015:text=Planc.", "title" => "For Plancius"),
Array("perseus" => "Perseus:text:1999.02.0015:text=Scaur.", "title" => "For Aemilius Scaurus"),
Array("perseus" => "Perseus:text:1999.02.0013:text=Rab. Post.", "title" => "For Rabirius Postumus"),
Array("perseus" => "Perseus:text:1999.02.0011:text=Mil.", "title" => "For Milo"),
Array("perseus" => "Perseus:text:1999.02.0011:text=Marc.", "title" => "For Marcellus"),
Array("perseus" => "Perseus:text:1999.02.0011:text=Lig.", "title" => "For Ligarius"),
Array("perseus" => "Perseus:text:1999.02.0011:text=Deiot.", "title" => "For King Deiotarius"),
Array("perseus" => "Perseus:text:1999.02.0011:text=Phil.", "title" => "Philippics"),
Array("perseus" => "Perseus:text:1999.02.0120", "title" => "On Oratory"),
Array("perseus" => "Perseus:text:1999.02.0009", "title" => "Letters to his Friends"),
Array("perseus" => "Perseus:text:1999.02.0008", "title" => "Letters to Atticus"),
Array("perseus" => "Perseus:text:1999.02.0017", "title" => "Letters to his brother Quintus"),
Array("perseus" => "Perseus:text:1999.02.0007", "title" => "Letters to Brutus")
		),
		"Cornelius Nepos"=> Array (
Array("perseus" => "Perseus:text:1999.02.0136:life=milt.", "title" => "Miltiades"),
Array("perseus" => "Perseus:text:1999.02.0136:life=them.", "title" => "Themistocles"),
Array("perseus" => "Perseus:text:1999.02.0136:life=ar.", "title" => "Aristides"),
Array("perseus" => "Perseus:text:1999.02.0136:life=paus.", "title" => "Pausanias"),
Array("perseus" => "Perseus:text:1999.02.0136:life=cim.", "title" => "Cimon"),
Array("perseus" => "Perseus:text:1999.02.0136:life=lys.", "title" => "Lysander"),
Array("perseus" => "Perseus:text:1999.02.0136:life=alc.", "title" => "Alcibiades"),
Array("perseus" => "Perseus:text:1999.02.0136:life=thr.", "title" => "Thrasybulus"),
Array("perseus" => "Perseus:text:1999.02.0136:life=con.", "title" => "Conon"),
Array("perseus" => "Perseus:text:1999.02.0136:life=di.", "title" => "Dion"),
Array("perseus" => "Perseus:text:1999.02.0136:life=iph.", "title" => "Iphicrates"),
Array("perseus" => "Perseus:text:1999.02.0136:life=cha.", "title" => "Chabrias"),
Array("perseus" => "Perseus:text:1999.02.0136:life=timoth.", "title" => "Timotheus"),
Array("perseus" => "Perseus:text:1999.02.0136:life=dat.", "title" => "Datames"),
Array("perseus" => "Perseus:text:1999.02.0136:life=ep.", "title" => "Epaminondas"),
Array("perseus" => "Perseus:text:1999.02.0136:life=pel.", "title" => "Pelopidas"),
Array("perseus" => "Perseus:text:1999.02.0136:life=ag.", "title" => "Agesilaus"),
Array("perseus" => "Perseus:text:1999.02.0136:life=eum.", "title" => "Eumenes"),
Array("perseus" => "Perseus:text:1999.02.0136:life=phoc.", "title" => "Phocion"),
Array("perseus" => "Perseus:text:1999.02.0136:life=timol.", "title" => "Timoleon"),
Array("perseus" => "Perseus:text:1999.02.0136:life=reg.", "title" => "Kings"),
Array("perseus" => "Perseus:text:1999.02.0136:life=ham.", "title" => "Hamilcar"),
Array("perseus" => "Perseus:text:1999.02.0136:life=han.", "title" => "Hannibal"),
Array("perseus" => "Perseus:text:1999.02.0136:life=ca.", "title" => "Cato"),
Array("perseus" => "Perseus:text:1999.02.0136:life=att.", "title" => "Atticus")
		),
		"Sulpicia"=> Array (
Array("perseus" => "Perseus:text:1999.02.0070:text=orig", "title" => "Poems")
		),
		"Vergil" => Array (
Array("perseus" => "Perseus:text:1999.02.0056", "title" => "Eclogues"),
Array("perseus" => "Perseus:text:1999.02.0059", "title" => "Georgics"),
Array("perseus" => "Perseus:text:1999.02.0055", "title" => "Aeneid")
		),
		"Horace" => Array (
Array("perseus" => "Perseus:text:1999.02.0024", "title" => "Odes"),
Array("perseus" => "Perseus:text:1999.02.0062", "title" => "Satires"),
Array("perseus" => "Perseus:text:1999.02.0064", "title" => "Ars Poetica")
		),
		"Livy" => Array (
Array("perseus" => "Perseus:text:1999.02.0027", "title" => "The History of Rome")
		),
		"Lucan" => Array (
Array("perseus" => "Perseus:text:1999.02.0133", "title" => "Civil War")
		),
		"Lucretius" => Array (
Array("perseus" => "Perseus:text:1999.02.0130", "title" => "De Rerum Natura")
		),
		"Ovid" => Array (
Array("perseus" => "Perseus:text:1999.02.0068:text=Am.", "title" => "Amores"),
Array("perseus" => "Perseus:text:1999.02.0068:text=Ep.", "title" => "Epistulae"),
Array("perseus" => "Perseus:text:1999.02.0068:text=Med.", "title" => "Medicamina Faciei Femineae"),
Array("perseus" => "Perseus:text:1999.02.0068:text=Ars", "title" => "Ars Amatoria"),
Array("perseus" => "Perseus:text:1999.02.0068:text=Rem.", "title" => "Remedia Amoris"),
Array("perseus" => "Perseus:text:1999.02.0029", "title" => "Metamorphoses")
		),
		"Phaedrus" => Array (
Array("perseus" => "Perseus:text:1999.02.0118", "title" => "Fables")
		),
		"Pliny the Elder" => Array (
Array("perseus" => "Perseus:text:1999.02.0138", "title" => "Naturalis Historia")
		),
		"Vitruvius" => Array (
Array("perseus" => "Perseus:text:1999.02.0072", "title" => "On Architecture")
		),
		"Augustus" => Array (
Array("perseus" => "Perseus:text:1999.02.0127", "title" => "Res Gestae")
		),
		"Pliny the Younger" => Array (
			Array("perseus" => "Perseus:text:1999.02.0139", "title" => "Epistulae")
		),
		"Suetonius" => Array (
Array("perseus" => "Perseus:text:1999.02.0061:life=jul.", "title" => "Divus Julius"),
Array("perseus" => "Perseus:text:1999.02.0061:life=aug.", "title" => "Divus Augustus"),
Array("perseus" => "Perseus:text:1999.02.0061:life=tib.", "title" => "Tiberius"),
Array("perseus" => "Perseus:text:1999.02.0061:life=cal.", "title" => "Caligula"),
Array("perseus" => "Perseus:text:1999.02.0061:life=cl.", "title" => "Divus Claudius"),
Array("perseus" => "Perseus:text:1999.02.0061:life=nero", "title" => "Nero"),
Array("perseus" => "Perseus:text:1999.02.0061:life=gal.", "title" => "Galba"),
Array("perseus" => "Perseus:text:1999.02.0061:life=otho", "title" => "Otho"),
Array("perseus" => "Perseus:text:1999.02.0061:life=vit.", "title" => "Vitellius"),
Array("perseus" => "Perseus:text:1999.02.0061:life=ves.", "title" => "Divus Vespasianus"),
Array("perseus" => "Perseus:text:1999.02.0061:life=tit.", "title" => "Divus Titus"),
Array("perseus" => "Perseus:text:1999.02.0061:life=dom.", "title" => "Domitianus")
		),
		"Servius" => Array (
Array("perseus" => "Perseus:text:1999.02.0053", "title" => "Commentary on the Aeneid of Vergil")
		),
		"Sallust" => Array (
Array("perseus" => "Perseus:text:1999.02.0123", "title" => "Catilinae Coniuratio"),
Array("perseus" => "Perseus:text:1999.02.0125", "title" => "Bellum Iugurthinum")
		),
		"New Testament" => Array (
Array("perseus" => "Perseus:text:1999.02.0060:book=Matthew", "title" => "Matthew"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Mark", "title" => "Mark"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Luke", "title" => "Luke"),
Array("perseus" => "Perseus:text:1999.02.0060:book=John", "title" => "John"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Acts", "title" => "Acts"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Romans", "title" => "Romans"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Corinthians", "title" => "1 Corinthians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Corinthians", "title" => "2 Corinthians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Galatians", "title" => "Galatians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Ephesians", "title" => "Ephesians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Philippians", "title" => "Philippians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Colossians", "title" => "Colossians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Thessalonians", "title" => "1 Thessalonians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Thessalonians", "title" => "2 Thessalonians"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Timothy", "title" => "1 Timothy"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Timothy", "title" => "2 Timothy"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Titus", "title" => "Titus"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Philemon", "title" => "Philemon"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Hebrews", "title" => "Hebrews"),
Array("perseus" => "Perseus:text:1999.02.0060:book=James", "title" => "James"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Peter", "title" => "1 Peter"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Peter", "title" => "2 Peter"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 John", "title" => "1 John"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 John", "title" => "2 John"),
Array("perseus" => "Perseus:text:1999.02.0060:book=3 John", "title" => "3 John"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Jude", "title" => "Jude"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Apocalypse", "title" => "Revelation")
		),
		"Old Testament" => Array (
Array("perseus" => "Perseus:text:1999.02.0060:book=Genesis", "title" => "Genesis"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Exodus", "title" => "Exodus"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Leviticus", "title" => "Leviticus"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Numbers", "title" => "Numbers"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Deuteronomy", "title" => "Deuteronomy"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Joshua", "title" => "Joshua"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Judges", "title" => "Judges"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Ruth", "title" => "Ruth"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Samuel", "title" => "1 Samuel"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Samuel", "title" => "2 Samuel"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Kings", "title" => "1 Kings"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Kings", "title" => "2 Kings"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Chronicles", "title" => "1 Chronicles"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Chronicles", "title" => "2 Chronicles"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Esdras", "title" => "1 Esdras"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Esdras", "title" => "2 Esdras"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Esther", "title" => "Esther"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Judith", "title" => "Judith"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Tobias", "title" => "Tobit"),
Array("perseus" => "Perseus:text:1999.02.0060:book=1 Maccabees", "title" => "1 Maccabees"),
Array("perseus" => "Perseus:text:1999.02.0060:book=2 Maccabees", "title" => "2 Maccabees"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Psalms", "title" => "Psalm"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Proverbs", "title" => "Proverbs"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Ecclesiastes", "title" => "Ecclesiastes"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Song of Songs", "title" => "Canticles"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Job", "title" => "Job"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Wisdom", "title" => "Wisdom"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Sirach", "title" => "Ecclesiasticus"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Hosea", "title" => "Hosea"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Amos", "title" => "Amos"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Micah", "title" => "Micah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Joel", "title" => "Joel"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Obadiah", "title" => "Obadiah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Jonah", "title" => "Jonah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Nahum", "title" => "Nahum"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Habbakuk", "title" => "Habakkuk"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Zephoniah", "title" => "Zephaniah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Haggaiah", "title" => "Haggai"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Zechariah", "title" => "Zechariah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Malachi", "title" => "Malachi"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Isaiah", "title" => "Isaiah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Jeremiah", "title" => "Jeremiah"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Baruch", "title" => "Baruch"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Lamentations", "title" => "Lamentations"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Ezekiel", "title" => "Ezekiel"),
Array("perseus" => "Perseus:text:1999.02.0060:book=Daniel", "title" => "Daniel")
		),
		"Boethius" => Array (
Array("perseus" => "Perseus:text:1999.02.0121", "title" => "Consolation of Philosophy")
		)
	);
?>