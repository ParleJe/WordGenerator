# Stworzyć generator słów/ciągów znaków.

###Założenia:
- Skrypt ma być wywoływany za pomocą CLI.
- Każde słowo musi składać się z samych liter z alfabetu angielskiego.
- W słowie mogą występować maksymalnie 2 spółgłoski z rzędu. 
- Każde słowo musi zaczynać się od spółgłoski, a drugą literą zawsze powinna być samogłoska.
- W ramach jednego wywołania skryptu każde słowo powinno być unikalne  
- Użytkownik ma mieć możliwość podania zakresu liczby znaków i ilości słów do wygenerowania.
- Każde wykonanie skryptu powinno kończyć się wpisaniem do pliku "generator.log" następujących informacji:
    - data wykonania skryptu,
    - ilość wygenerowanych słów,
    - Minimalną i maksymalna ilość znaków.
- Jeżeli skrypt rzuca jakieś wyjątki, te również powinny znaleźć się osobnym pliku "exceptions.log"
- Skrypt powinien posiadać blokadę czasową, która uniemożliwi wywołanie go pomiędzy piątkiem od godz 15:00 a poniedziałkiem do 10:00, chyba że do wywołania komendy zostanie dodany parametr "--force"
###Działanie
`php ./index.php <zakres liter> <liczba słów> <flaga "--forced"> `
- zakres liter podawany  postaci `x-y` gdzie x i y to liczby całkowite
- ustawienie flagi `--forced` umożliwia działanie skryptu bez blokady czasowej