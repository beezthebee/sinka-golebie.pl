<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="llllll.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontell/css/fontello.css" type="text/css" />
	
	<script src="main.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
	
	<nav class="menu">
		
		<div class="containerlogo">
			<img src="img/logo.jpg">
		</div>
	
	</nav>
	
	
	<section class="content">
	
		<header class="greet">
		Zarejestruj się
		</header>

		<div class="wrapper">
			
			<?php
			
				if (isset($_SESSION['feedback'])) echo $_SESSION['feedback'].'<br>';
				unset ($_SESSION['feedback']);
			
			?>
			
			<form action="registering.php" method="post">
				<br>Login: <br><input type="text" name="login" class="input"/><br>
				<?php 
					if (isset($_SESSION['e_login'])) echo $_SESSION['e_login'];
					unset($_SESSION['e_login']);
				?>
				
				<br>E-mail: <br><input type="text" name="email" class="input"/><br>
				<?php 
					if (isset($_SESSION['e_email'])) echo $_SESSION['e_email'];
					unset($_SESSION['e_email']);
				?>
				
				<br>Hasło: <br><input type="password" name="password1" class="input"/><br>
				<?php 
					if (isset($_SESSION['e_password_length']) && isset($_SESSION['e_password_identity'])){
						echo $_SESSION['e_password_length'];
						unset($_SESSION['e_password_length']);
					}
				?>
				
				<br>Powtórz hasło: <br><input type="password" name="password2" class="input"/><br>
				<?php 
					if (isset($_SESSION['e_password_length']) && !isset($_SESSION['e_password_identity'])) {
						echo $_SESSION['e_password_length'];
						unset($_SESSION['e_password_length']);
					}
					else if (isset($_SESSION['e_password_identity'])){
						echo $_SESSION['e_password_identity'];
						unset($_SESSION['e_password_identity']);
					}
				?>
				
				<br><label><input type="checkbox" name="tos" style="letter-spacing: 0;"/> Akceptuję</label><br>
				<div class="tos">regulamin i politykę prywatności</div>
				<div class="popup">
				<i class="icon-cancel close"></i><br><br>
				<div style="height: 630px; overflow-y: auto;">
				<div class="tos-title"><br>OGÓLNE WARUNKI UŻYTKOWANIA STRONY INTERNETOWEJ<br>
				(REGULAMIN)<br><br><br><br>

				1. PREAMBUŁA</div><br><br>

				<div class="tos-content">1. Niniejszy dokument określa warunki dostępu i korzystania ze strony internetowej, zwany będzie dalej: <b>Ogólne warunki</b><br><br>

				2. Każdy Użytkownik z chwilą podjęcia czynności zmierzających do korzystania ze strony internetowej zobowiązany jest do zapoznania się, przestrzegania oraz akceptacji Ogólnych warunków, bez ograniczeń i zastrzeżeń.<br><br>

				3. W przypadku niewyrażenia zgody na wszystkie Ogólne warunki należy zaprzestać korzystania ze strony internetowej i natychmiast ją opuścić.<br><br>

				4. Wszystkie nazwy handlowe, nazwy firm i ich logo, użyte na stronie internetowej należą do ich właścicieli i są używane wyłącznie w celach identyfikacyjnych. Mogą być one zastrzeżone znakami towarowymi.<br><br>

				5. Zabrania się nieuprawnionego korzystania z zawartości strony intemetowej, utworów lub informacji jak też ich nieuprawnionej reprodukcji, retransmisji lub innego użycia jakiegokolwiek elementu strony internetowej, gdyż takie działanie może naruszać m.in. prawa autorskie lub chronione znaki towarowe.<br><br>

				6. Pytania lub uwagi dotyczące strony internetowej można zgłaszać na następujący adres email: simer85.85@onet.pl.<br><br><br><br></div>

				<div class="tos-title">II. DEFINICJE</div><br><br>

				<div class="tos-content">1. <b>FORMULARZ REJESTRACJI</b> - kwestionariusz dostępny na stronie internetowej umożliwiający rejestrację i tworzenie Konta na stronie internetowej<br><br>

				2. <b>KONTO</b> - oznaczony indywidualną nazwą lub loginem oraz hasłem zbiór zasobów na stronie internetowej, w którym gromadzone są dane Użytkownika;<br><br>

				3. <b>PRAWO WŁAŚCIWE</b> - Do celów realizacji Ogólnych warunków zastosowanie ma prawo polskie;<br><br>

				4. <b>STRONA INTERNETOWA</b> - narzędzie, o nazwie: www sinka-golebie.pl, służące do świadczenia usług elektronicznych;<br><br>

				5. <b>UŻYTKOWNIK</b> - osoba fizyczna, osoba prawna albo jednostka organizacyjna nieposiadająca osobowości prawnej, której ustawa przyznaje zdolność prawną, korzystająca z usług elektronicznych dostępnych w ramach strony internetowej;<br><br>

				6. <b>WARUNKI</b> - zbiór wszystkich postanowień m.in. niniejszych Ogólnych warunków, zasad polityki prywatności, plików cookies, regulaminu korzystania ze sklepu internetowego oraz wszelkich innych warunków, znajdujących się na stronie internetowej, które dotyczą określonych funkcj, właściwości lub promocji jak również obsługi klienta;<br><br>

				7. <b>WŁAŚCICIEL</b> - Podmiot udostępniający niniejszą stronę internetową, mianowicie: Pan Adam Sinka, zamieszkały przy: ul. Śmiłowicka 19, 40-782 Katowice<br><br><br><br></div>
				
				<div class="tos-title">III. ZAKRES WARUNKÓW</div><br><br>

				<div class="tos-content">1. Właściciel zapewnia dostęp do zawartości strony internetowej, zgodnie z poniższymi Ogólnym warunkami.<br><br>

				2. Zawartość i dane publikowane na stronie internetowej mają charakter informacji dla osób zainteresowanych i mogą być wykorzystywane jedynie do celów informacyjnych.<br><br>

				3. Właściciel ma prawo zamieszczania treści reklamowych, które stanowią integralną część serwisu i prezentowanych w nim materiałów.<br><br>

				4. Użytkownicy mogą korzystać z dostępu i usług oferowanych na stronie internetowej, pod warunkiem uprzedniego wyrażenia zgody na Ogólne warunki.<br><br><br><br></div>

				<div class="tos-title">IV. ZASADY KORZYSTANIA ZE STRONY INTERNETOWEJ</div><br><br>

				<div class="tos-content">1. Strona internetowa jest obsługiwana przez wszelkiego rodzaju przeglądarki internetowe. Nie wymaga się żadnych szczególnych właściwości urządzenia końcowego Użytkownika.<br><br>

				2. Po zaakceptowaniu Warunków, Użytkownik ma prawo przeglądać, kopiować, drukować oraz
				rozpowszechniać, bez dokonywania zmian w treści, zawartość niniejszej strony internetowej, pod warunkiem, że:<br><br>

				&emsp; a. treści te będą wykorzystywane wyłącznie informacyjnie, w celach niekomercyjnych;<br><br>

				&emsp; b. każda wykonana kopia będzie zawierała informacje na temat praw autorskich lub dane dotyczące autora treści.<br><br>

				3. Zakazane jest używanie I kopiowanie oprogramowania, procesów i technologii stanowiących część strony internetowej.<br><br>

				4. Użytkownicy mogą korzystać ze strony intemetowej jedynie w poszanowaniu przepisów ustawy prawo elekomunikacyjne, ustawy o świadczeniu usług drogą elektroniczną i odpowiednich przepisów prawa cywilnego.<br><br>

				5. Zabronione jest korzystanie ze strony internetowej.<br><br>
				&emsp; a. w sposób prowadzący do naruszenia obowiązujących przepisów prawa;<br><br>

				&emsp; b. w jakikolwiek sposób niezgodny z prawem lub nieuczciwy, albo w sposób, zmierzający do osiągnięcia niezgodnego z prawem lub nieuczciwego celu;<br><br>

				&emsp; c. do celów związanych z wyrządzaniem szkody dzieciom lub prób wyrządzenia im jakiejkolwiek
				szkody;<br><br>

				&emsp; d. do wysyłania, świadomego otrzymywania, wgrywania lub używania treści niezgodnych z Ogólnymi warunkami;<br><br>

				&emsp; e. do przekazywania lub prowokowania wysyłki jakichkolwiek niezamówionych lub nieuprawnionych reklam lub materiałów promocyjnych, jak również jakichkolwiek form podobnych, zaliczanych do zbiorczej kategorii SPAM;<br><br>

				&emsp; f. do świadomego przekazywania jakichkolwiek danych, wysyłania lub wgrywania jakichkolwiek materiałów zawierających wirusy, konie trojańskie, oprogramowanie szpiegujące (spyware), oprogramowanie z reklamami (adware) lub inny szkodiwy program lub zbliżone kody komputerowe zaprogramowane, by niekorzystnie wpływać lub zagrażać na funkcjonowanie jakiegokolwiek: oprogramowania lub sprzętu komputerowego albo niekorzystnie wpływać lub zagrażać Użytkownikowi.<br><br><br><br></div>
				
				<div class="tos-title">V. LINKI ZEWNĘTRZNE</div><br><br>

				<div class="tos-content">1. Odnośniki znajdujące się na niniejszej stronie, do innych stron internetowych, są podane wyłącznie w celu informacyjnym.<br><br>

				2. Właściciel strony internetowej nie ponosi odpowiedzialności za treści znajdujące się na innych witrynach, ani za jakiekolwiek szkody wynikające z ich użytkowania.<br><br><<br><br></div>

				<div class="tos-title">VI. FORMULARZ REJESTRACJI</div><br><br>

				<div class="tos-content">1. W ramach formularza rejestracji, Użytkownik może wpisać swoje dane osobowe, aby zarejestrować się jako zidentyfikowany Użytkownik na stronie internetowej i utworzyć swoje Konto.<br><br>

				2. Po zarejestrowaniu, gdy Użytkownik odwiedzi ponownie stronę internetową, będzie mógł zalogować się jako zidentyfikowany Użytkownik na swoje Konta.<br><br>

				3. Po zalogowaniu na Konto, strona internetowa będzie dysponowała danymi osobowymi i kontaktowymi Użytkownika, podanymi podczas rejestracji lub w późniejszym okresie, które umożliwią sprawniejszy kontakt, przesył danych lub płatność za usługę lub towary, dostępne na stronie internetowej.<br><br>

				4. Zarejestrowanie Użytkownika i w rezultacie zapisanie Jego danych osobowych oznacza, że Użytkownik wyraził zgodę na przetwarzanie przez Właściciela danych osobowych Użytkownika, podanych w Formularzu Rejestracji.<br><br><br><br></div>

				<div class="tos-title">VII. POSZANOWANIE WŁASNOŚCI INTELEKTUALNEJ</div><br><br>

				<div class="tos-content">1. Strona internetowa oraz jej treści mogą być chronione prawami autorskimi, prawami dotyczącymi znaków towarowych oraz innymi przepisami, związanymi ochroną własności intelektualnej.<br><br>

				2 Znaki, loga i inne spersonalizowane emblematy Właściciela, pojawiające się na stronie internetowej (zwane łącznie: "Znakami"), stanowią znaki towarowe Właściciela.<br><br>

				3. Z wyjątkiem osobnych, indywidualnych, pisemnych upoważnień, Użytkownik nie może wykorzystywać przez siebie, należących do Właściciela, Znaków: osobno, ani w zestawieniu z innymi elementami słownymi lub graficznymi, szczególnie w informacjach prasowych, reklamach, materiałach promocyjnych, marketingowych, w mediach, w materiałach pisemnych lub ustnych, w formie elektronicznej, w formie wizualnej ani w żadnej innej formie.<br><br><br><br></div>

				<div class="tos-title">VIII. OCHRONA DANYCH UŻYTKOWNIKA</div><br><br>

				<div class="tos-content">Właściciel szanuje w pełni prywatność Użytkowników. Szczegółowe informacje na temat sposobu gromadzenia i przetwarzania danych osobowych Użytkownika lub innych informacji jak również sytuacji, w których Właściciel może je ujawniać, znajdują się w zakładce Poliyka Prywatności.<br><br><br><br></div>

				<div class="tos-title">IX. OGRANICZENIE ODPOWIEDZIALNOŚCI</div><br><br>

				<div class="tos-content">1. Strona internetowa zawiera informacje o charakterze ogólnym. Nie ma na celu pośredniczyć w świadczeniu jakichkolwiek usług doradztwa profesjonalnego. Przed podjęciem czynności mających wpływ na sytuację finansową lub działalność gospodarczą Użytkownika należy skontaktować się z profesjonalnym doradcą.<br><br>

				2. Strona internetowa nie zapewnia żadnych gwarancji dotyczących jej treści, w szczególności gwarancji bezpieczeństwa, bezbłędności, braku wirusów czy złośliwych kodów, gwarancji dotyczących poprawnego działania czy jakości.<br><br>
				
				3. Strona internetowa nie zapewnia żadnej rękojmi, wyraźnej lub dorozumianej, w tym gwarancji przydatności handlowej lub przydatności do określonego celu, nienaruszenia praw autorskich, dostosowania, bezpieczeństwa i rzetelności informacji.<br><br>

				4. Użytkownik korzysta ze strony internetowej na własne ryzyko i przyjmuje na siebie pełną odpowiedzialność za szkody związane lub wynikające z jej wykorzystania, zarówno bezpośrednie jak i pośrednie, uboczne, następcze, moralne, lub inne szkody z tytułu odpowiedzialności umownej, deliktowej, z tytułu zaniedbań, w tym m.in. za utratę danych lub usług.<br><br>

				5. Strona internetowa nie ponosi żadnej odpowiedzialności za linki zamieszczone na stronie internetowej, szczególnie jeśi prowadzą do witryn, zasobów lub narzędzi utrzymywanych przez osoby trzecie.<br><br>

				6. Właściciel nie ponosi odpowiedzialności jeśli strona internetowa jest z jakichkolwiek przyczyn tymczasowo lub długookresowo niedostępna.<br><br>

				7. Właściciel nie ponosi opowiedzialności za informacje przekazywane na stronie internetowej, ani też nie może zapewnić całkowitego bezpieczeństwa transakcji lub komunikacji prowadzonych za pomocą strony internetowej.<br><br>

				8. Pomimo podejmowania przez Właściciela największych starań, w kwestii zapewnienia dokładności i aktualności strony internetowej, mogą pojawić się niezamierzone przez Właściciela błędy, które Użytkownik, po ich wykryciu, proszony jest zgłaszać Właścicielowi.<br><br>

				9. Wszystkie wskazane powyżej wyłączenia i ograniczenia odpowiedzialności obowiązują w najszerszym dopuszczalnym prawnie zakresie, obejmując każdy typ istniejącej odpowiedzialności m.in. odpowiedzialności kontraktowej, deliktowej i każdej innej przewidzianej w polskim lub zagranicznym porządku prawnym.<br><br><br><br></div>

				<div class="tos-title">X. STOSUNEK DO ZAWARTYCH UMÓW</div><br><br>

				<div class="tos-content">Jeśli nie postanowiono inaczej, Ogólne warunki stanowią kompletną i wyczerpującą umowę pomiędzy Użytkownikiem i Właścicielem, dotyczącą korzystania ze strony internetowej, w zakresie treści w nich zawartych oraz zastępują wszelkie inne porozumienia, uzgodnienia i umowy dotyczące przedmiotu
				(treści) niniejszych Ogólnych warunków.<br><br><br><br></div>

				<div class="tos-title">XI. ZMIANA WARUNKÓW STRONY INTERNETOWEJ</div><br><br>

				<div class="tos-content">1. Właściciel strony internetowej zastrzega sobie prawo do dokonywania modyfikacji niniejszych Ogólnych warunków, w dowolnym momencie ich obowiązywania, zamieszczając ich zaktualizowaną wersję na stronie internetowej, które zaczynają obowiązywać Użytkowników od momentu ich publikacji, chyba że inaczej wskazano w zmodyfikowanych Ogólnych warunkach.<br><br>

				2. Użytkownik ma obowiązek zapoznania się z modyfikacjami Ogólnych warunków, o czym Właściciel poinformuje go, wysyłając do Niego wiadomość lub komunikat o zmianach Ogólnych warunków do zaakceptowania.<br><br><br><br></div>
				
				<div class="tos-title">XII. ROZWIĄZYWANIE SPORÓW</div><br><br>
				<div class="tos-content">1. Wszelkie powstałe spory Strony postanawiają w pierwszej kolejności rozwiązać w rybie polubownego załatwienia sprawy, przed właściwym sądem polubownym (zapis na sąd polubowny).<br><br>

				2. Jeśli polubowne załatwienie sprawy okaże się niemożliwe, spór wynikający z niniejszej umowy zostanie rozstrzygnięty przez sąd, w którego okręgu znajduje się miejsce zamieszkania lub stałego pobytu Właściciela.<br><br><br><br></div>

				<div class="tos-title">XIII. PODSTAWA PRAWNA</div><br><br>

				<div class="tos-content">1. W sprawach nieuregulowanych w niniejszych Ogólnych warunkach stosuje się odpowiednio następujące ustawy:<br><br>

				&emsp; a. ustawę prawo telekomunikacyjne z dnia 16 lipca 2004 r. (t.j. Dz.U. z 2019 r. poz. 2460, ze zm.);<br><br>

				&emsp; b. ustawę o świadczeniu usług drogą elektroniczną z dnia 18 lipca 2002 r. (t.j. Dz.U. z 2019 r. poz. 123, ze zm.);<br><br>

				&emsp; c. ustawę o prawie autorskim i prawach pokrewnych z dnia 4 lutego 1994 r. (t.j. Dz. U. z 2019 r. poz. 1231, ze zm.);<br><br>

				&emsp; d. ustawę Kodeks Cywilny z dnia 23 kwietnia 1964 r. (t.j. Dz.U. z 2019 r. poz. 1145, ze zm.);<br><br>

				oraz inne właściwe przepisy prawa polskiego.<br><br><br><br></div>
				
				<div class="tos-title">POLITYKA PRYWATNOŚCI<br>
				STRONY INTERNETOWEJ WWW.SINKA-GOLEBIE.PL<br><br><br><br></div>

				<div class="tos-content">1. Dla Właściciela oraz administratora niniejszej strony internetowej, ochrona danych osobowych Użytkowników jest sprawą najwyższej wagi. Dokładają oni ogrom starań, aby Użytkownicy czuli się bezpiecznie, powierzając swoje dane osobowe w trakcie korzystania ze strony internetowej.<br><br>

				2. Użytkownik to osoba fizyczna, osoba prawna albo jednostka organizacyjna, nieposiadająca osobowości prawnej, której ustawa przyznaje zdolność prawną, korzystająca z usług elektronicznych, dostępnych w ramach strony internetowej.<br><br>

				3. Niniejsza polityka prywatności wyjaśnia zasady i zakres przetwarzania danych osobowych Użytkownika, przysługujące mu prawa, jak też obowiązki administratora tych danych, a także informuje o używaniu plików cookies.<br><br>

				4. Administrator stosuje najnowocześniejsze środki techniczne i rozwiązania organizacyjne, zapewniające wysoki poziom ochrony przetwarzanych danych osobowych oraz zabezpieczenia przed dostępem osób nieupoważnionych.<br><br><br><br></div>

				<div class="tos-title">I. ADMINISTRATOR DANYCH OSOBOWYCH<br><br></div>
				<div class="tos-content">Administratorem danych osobowych jest Pani Kinga Słota, zamieszkała przy: ul. Rybacka 6, 40-763
				Katowice (zwany dalej: „Administrator").<br><br>

				Właścicielem strony internetowej jest Pan Adam Sinka, zamieszkały przy: ul. Śmiłowicka 19, 40-782 Katowice (zwany dziej: „Właściciel").<br><br><br><br></div>

				<div class="tos-title">II. CEL PRZETWARZANIA DANYCH OSOBOWYCH<br><br></div>

				<div class="tos-content">1. Administrator przetwarza dane osobowe Użyrkownika w celu potwierdzenia tożsamości Użytkownika oraz zapobiegania wykorzystywaniu cudzych danych
				osobowych przez Użytkownika.<br><br>

				2. Oznacza to, że dane te są potrzebne w szczególności do zarejestrowania się na stronie internetowej.<br><br>

				3. Użytkownik może również wyrazić zgodę na otrzymywanie informacji o nowościach i promocjach, co spowoduje, że administrator będzie również przetwarzać dane osobowe, w celu przesyłania Użytkownikowi informacji handlowych, dotyczących m.in. nowych produktów lub usług, promocji czy wyprzedaży.<br><br>

				4. Dane osobowe są również przetwarzane w ramach wypełnienia prawnych obowiązków, ciążących na administratorze danych oraz realizacji zadań, w interesie publicznym m.in. do wykonywania zadań, związanych z bezpieczeństwem i obronnością lub przechowywaniem dokumentacji podatkowej.<br><br>

				5. Dane osobowe mogą być również przetwarzane w celach marketingu bezpośredniego produktów, zabezpieczenia i dochodzenia roszczeń lub ochrony przed roszczeniami Użytkownika lub osoby trzeciej, jak również marketingu usług i produktów podmiotów trzecich lub marketingu własnego, niebędącego marketingiem bezpośrednim.<br><br><br><br></div>

				<div class="tos-title">III. RODZAJ DANYCH<br><br></div>

				<div class="tos-content">Administrator przetwarza następujące dane osobowe, których podanie jest niezbędne do zarejestrowania się na stronie internetowej:<br><br>
				
				&emsp; - adres e-mail.<br><br><br><br></div>
				
				<div class="tos-title">IV. PODSTAWA PRAWNA PRZETWARZANIA DANYCH OSOBOWYCH<br><br></div>

				<div class="tos-content">1. Dane osobowe są przetwarzane zgodnie z przepisami Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych), OJ L 119, 4.5.2016, p. 1-88, dalej
				zwane: „rozporządzenie RODO".<br><br>

				2. Administrator przetwarza dane osobowe wyłącznie po uprzednim uzyskaniu zgody Użytkownika, wyrażonej w chwili rejestracji na stronie internetowej.<br><br>

				3. Wyrażenie zgody na przetwarzanie danych osobowych jest całkowicie dobrowolne, jednakże brak jej udzielenia uniemożliwia zarejestrowanie sę na stronie internetowej.<br><br><br><br></div>

				<div class="tos-title">V. PRAWA PRZYSŁUGUJĄCE UŻYTKOWNIKOWI<br><br></div>

				<div class="tos-content">1. Użytkownik może w każdej chwili zażądać od administratora informacji o zakresie przetwarzania danych osobowych.<br><br>

				2. Użytkownik może w każdej chwili zażądać poprawienia bądź sprostowania swoich danych osobowych. Użytkownik może to również zrobić samodzielnie, po zalogowaniu się na swoje konto.<br><br>

				3. Użytkownik może w każdej chwili wycofać swoją zgodę na przetwarzanie jego danych osobowych, bez podawania przyczyny. Żądanie nieprzetwarzania danych może dotyczyć wskazanego przez Użytkownika konkretnego celu przetwarzania np. wycofanie zgody na otrzymywanie informacji handlowych bądź dotyczyć wszystkich celów przetwarzania danych. Wycofanie zgody co do wszystkich celów przetwarzania spowoduje, że konto Użytkownika zostanie usunięte ze strony internetowej, wraz ze wszystkimi wcześniej przetwarzanymi przez administratora danymi osobowymi Użytkownika. Wycofanie zgody nie wpłynie na już dokonane czynności.<br><br>

				4. Użytkownik może w każdej chwili żądać, bez podawania przyczyny, aby administrator usunął Jego dane. Żądanie usunięcia danych nie wpłynie na dotychczas dokonane czynności. Usunięcie danych oznacza jednoczesne usunięcie konta Użytkownika, wraz ze wszystkimi zapisanymi i przetwarzanymi do tej pory przez administratora danymi osobowymi.<br><br>

				5. Użytkownik może w każdej chwili wyrazić sprzeciw przeciwko przetwarzaniu danych osobowych, zarówno w zakresie wszystkich przetwarzanych przez administratora danych osobowych Użytkownika, jak również jedynie w ograniczonym zakresie np. co do przetwarzania danych w konkretnie wskazanym celu. Sprzeciw nie wpłynie na dotychczas dokonane czynności. Wniesienie sprzeciwu spowoduje usunięcie konta Użytkownika, wraz ze wszystkimi zapisanymi i przetwarzanymi do tej pory, przez administratora, danymi osobowymi.<br><br>

				6. Użytkownik może zażądać ograniczenia przetwarzania danych osobowych, czy to przez określony czas, czy też bez ograniczenia czasowego, ale w określonym zakresie, co administrator będzie obowiązany spełnić. Żądanie to nie wpłynie na dotychczas dokonane czynności.<br><br>

				7. Użytkownik może zażądać, aby administrator przekazał innemu podmiotowi, przetwarzane dane osobowe Użytkownika. Powinien w tym celu napisać prośbę do administratora, wskazując, jakiemu podmiotowi (nazwa, adres) należy przekazać dane osobowe Użytkownika oraz jakie konkretnie dane Użytkownik życzy sobie, żeby administrator przekazał. Po potwierdzeniu przez Użytkownika swojego życzenia, administrator przekaże, w formie elekaronicznej, wskazanemu podmiotowi, dane osobowe
				Użytkownika. Potwierdzenie przez Użytkownika żądania jest niezbędne z uwagi na bezpieczeństwo danych osobowych Użytkownika oraz uzyskanie pewności, że żądanie pochodzi od osoby uprawnionej.<br><br>

				8. Administrator informuje Użytkownika o podjętych działaniach, przed upływem miesiąca od otrzymania jednego z żądań wymienionych w poprzednich punktach.<br><br><br><br></div>
				
				<div class="tos-title">VI. POWIERZENIE PRZETWARZANIA DANYCH INNYM PODMIOTOM<br><br></div>

				<div class="tos-content">1. Administrator może powierzać przetwarzanie danych osobowych podmiotom współpracującym z administratorem, w zakresie niezbędnym dla realizacji transakcji np. w celu przygotowania zamówionego towaru oraz dostarczania przesyłek lub przekazywania informacji handlowych, pochodzących od administratora (ostatnie dotyczy Użytkowników, którzy wyrazili zgodę na otrzymywanie
				informacji handlowych).<br><br>

				2. Poza celami, wskazanymi w niniejszej Polityce Prywatności, dane osobowe Użytkowników, nie będą w żaden sposób udostępniane osobom trzecim, ani przekazywane innym podmiotom, w celu przesyłania materiałów marketingowych tych osób trzecich.<br><br>

				3. Dane osobowe Użytkowników strony internetowej nie są przekazywane poza obszar Unii Europejskiej.<br><br>

				4. Niniejsza Poltyka Prywatności jest zgodna z przepisami wynikającymi z art. 13 ust. 1 i ust. 2 rozporządzenia RODO.<br><br></div></div></div>
				
				<script>
					const tos = document.querySelector('.tos');
					const popup = document.querySelector('.popup');
					const close = document.querySelector('.close');
					
					tos.addEventListener('click', () => { 
						popup.classList.toggle('popup-active'); 
					});
					
					close.addEventListener('click', () => { 
						popup.classList.toggle('popup-active'); 
					});
				</script>
				
				<?php 
					if (isset($_SESSION['e_checkbox'])) echo $_SESSION['e_checkbox'];
					unset($_SESSION['e_checkbox']);
				?>
				<div style="width: 50%; margin: 0 auto; letter-spacing: 0;">
				<br><label><input type="checkbox" name="notif"/> * Wyrażam zgodę na otrzymywanie powiadomień oraz informacji handlowej kierowanych do mnie za pomocą poczty elektronicznej na podany przeze mnie adres e-mail</label><br><br>
				<span style="font-size: 1rem;">*Pole nie jest wymagane</span>
				</div>
				
				<br><div class="g-recaptcha captcha" data-sitekey="6LdVMnUeAAAAABbz_9skrW85oawuIZF-8oeTO6O7"></div>
				<?php 
					if (isset($_SESSION['e_captcha']) && isset($_SESSION['e_captcha'])){
						echo $_SESSION['e_captcha'];
						unset($_SESSION['e_captcha']);
					}
				?>
				
				<br><input type="submit" name="submit" value="Zarejestruj się" class="button"/><br>
				<input type="button" onclick="location.href = 'index.php';" value="Wróć" class="button"/>
			</form>
		</div>
	</section>
	
	<?php
		include 'footer.php'
	?>
	
</body>
</html>