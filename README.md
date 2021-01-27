# PHP_projekt

## Projekt zaliczeniowy przedmiotu Interaktywne serwisy internetowу - Serwer dla amatorów wspinaczki
> celem projektu jest kolekcjonowanie zdjęć sportowców zarejestrowanych na portalu. Użytkownicy mogą dodawać swoi zdjecia na portal w sposób publiczny i priwatny. A także zapisywać zdjęcia innych użytkowników

### Projekt zawiera: 
* Zapisywanie wartości z formatek do bazy danych
* Mechanizm uwierzytelniania
* Wdrożenie na serwerze WWW
* Worzenie widoków w sposób komponentowy
* Zastosowanie biblioteki JS
* Zastosowanie biblioteki CSS/Estetyka wykonania warstwy widoków
* Przesyłanie plików na serwer
* Galeria przesłanych zdjęć
* Wykorzystanie bazy danych 
* AJAX – wyszukiwarka zdjęć 
* Funkcyjna implementacja wzorca MVC


### Strona startowa
![index](php/index.jpg)
#### Tutaj znajduje się  ciekawy script z pomocą którego możemy przenosić obiekt (gdzie w css position: absolute)
```
$(document).ready(function () { 
    $(".muvediv").draggable({ cursor: "move" });
});
```
![index](php/prz.jpg)


#### Poprzez kliknięcie na przycisk rejestracji (z ruchomym napisem) - idziemy do strony formularza 

### Formularz rejestracyjny
![form](php/rejestracja.jpg)

#### Na dole formularza widzimy już zarejestrowanych użytkowników w bazie danych
![form](php/rejestracja2.jpg)
#### Podczas wypełniania wszystkich pól po lewej stronie zostanie podświetlone napis:
![form](php/rejestracja1.jpg)

#### zapamiętanie aktualnego stanu serwisu

```
<?php	
	if ( !empty( $_SESSION['youname']) && !empty( $_SESSION['userid'])){
		if (!empty( $_GET["add"]) ){
			setcookie("youname", $_SESSION['youname'], time() + 60 * 60 * 24 * 5, "/"); //5 days
			setcookie("userid", $_SESSION['userid'] , time() + 60 * 60 * 24 * 5, "/"); //5 days	
			$_SESSION['cartp'] = [];
			setcookie("cartp", null , time() + 60 * 60 * 24 * 5, "/"); //5 days	
		}
	}else{
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';
		$_SESSION['cartp'] = [];	
		setcookie("cartp", null , time() + 60 * 60 * 24 * 5, "/"); //5 days		
	}	
	if (!empty( $_GET["exit"]) ){
		$_SESSION = array();
		setcookie("youname", '', time() - 60 * 60 * 24 * 5, '/');
		setcookie("userid", '', time() - 60 * 60 * 24 * 5, '/');
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';	
		$_SESSION['cartp'] = [];
		setcookie("cartp", null , time() + 60 * 60 * 24 * 5, "/"); //5 days
	}	

?>
```
### Logowanie
#### Zalogować się użytkownik może w tym formularze 
![form](php/logowanie.jpg)

### Galeria zdjęć
![galeria](php/galeria.jpg)
#### Niezarejestrowani użytkownicy mogą oglądać galerię, ale tylko u zarejestrowanych wyświetla się funkcja dodawania
![galeria](php/dodacZd.jpg)
#### Pliki mogą być tylko w formacie PNG lub JPG, nie więcej niż 1 MB. Jeśli użytkownik spróbuje wysłać zdjęcie o większym rozmiarze lub w innym formacie, powinien otrzymać stosowny komunikat

#### Zawiera znak wodny (w prawej części zdjęcia na dole)
#### Również możemy wybrać publikację prywatną lub publiczną
![galeria](php/dodanieZd1.jpg)
#### Użytkownik może zobaczyć dodane swoi zdjęcia w "show my"
![galeria](php/dodanieZd2.jpg)
####  Po kliknięciu dowolnego zdjęcia z galerii, użytkownik może zapisać ją dla siebie
![galeria](php/selected.jpg)

#### Zapisane zdjęcia są w "Show choose"
![galeria](php/selected3.jpg)
#### Również jest funkcja usunięcia
![galeria](php/selected2.jpg)

### Wyszukiwarka
#### Funkcja wyszukiwania znajduje się w "Seek by name photo"
![galeria](php/wyszukiw.jpg)
#### Z pomocą ajax znajdujemy zdjecie po nazwie
![galeria](php/wyszukiw1.jpg)
