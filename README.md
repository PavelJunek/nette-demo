Nette Demo
----------

Jednoduché blogovadlo vytvořené v Nette.

1. Po stažení zdrojových kódů otevřete příkazový řádek, přejděte do adresáře s tímto projektem a spusťte příkaz "composer install". Ten se postará o stažení Nette frameworku a všech závislostí.

2. Vytvořte si MySQL databázi a importujte do ní definice tabulek pomocí souboru sql/demo.sql. Pokud je to potřeba, vytvořte v databázi také uživatele a nastavte mu práva pro přístup k demo databázi.

3. Zkopírujte soubor app/config/config.local.example.neon do app/config/config.local.neon a vyplňte v něm přístupové údaje pro databázi.

4. Nastavte oprávnění pro adresáře temp a log tak, aby do nich mohl zapisovat web server (na Unixu použijte např. chmod 777 temp log).

5. Nastavte adresář www jako kořenový adresář svého web serveru. Alternativně ho můžete připojit jako podadresář např. pomocí liků (na Unixu např. ln -s cesta-k-projektu/www demo). V tom případě upravte soubor www/.htaccess tak, aby obsahovat řádek RewriteBase /demo (nebo jiný název, podle toho, jak jste pojmenovali odkaz).

6. Spusťte prohlížeč a vyzkoušejte na adrese http://localhost nebo http://localhost/demo (podle toho, kam jste ve web serveru projekt umístili).

7. Pro přihlašování slouží uživatelské jméno "admin" a heslo "admin".