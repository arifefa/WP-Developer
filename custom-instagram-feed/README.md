### Custom Instagram Feed
- copy  folder ke child-theme
- buka **function.php** pada child-theme
- tambahkan code berikut:
```php
require_once('custom-instagram-feed/scripts.php');
```
- dan save
---
penggunaan shortcode:
```html
[instagram username="gradindesign" sid="52614606195%3A0j0Oo82b6m5fTM%3A12" layout="6" small="6" meidum="4" large="4"]
```
username: _username instagram_
sid: _sessionid from cookies (in web browser, login instagram, F12 > network > choose page > cookies > get sessionid )_
layout: _number of post want to display_
small: _small col class for mobile (number) for responsive_
medium: _medium col class for tablet (number) for responsive_
large: _large col class for desktop (number) for responsive_
___