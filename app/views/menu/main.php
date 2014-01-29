<?php

echo Navbar::create()->with_menus(Navigation::links(Category::menu()), array(), true, true);
