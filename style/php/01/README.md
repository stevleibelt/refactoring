# Styling Old PHP Code

## General

So what is my intention here?

I have created three files:
* [01_not_styled.php](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/01_not_styled.php)
* [02_basically_styled.php](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/02_basically_styled.php)
* [03_styled.php](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/03_styled.php)
* [04_refactored.php](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/04_refactored.php)

Go throw the files step by step. Open the first and the second file near by each other and try to find the parts. After that, close file one and open the third file beside the second file and compare them.
I also included a fourth file called "refactored" where I also made logical changes. This is something that has to be done after styling and with care.

Last but not least, have a look on the following lines and compare if the changes I explained are fitting your notes.

One last word. There is a small line between well know general styling and organisation wide excepted styling.

## Styling Steps

### From [01](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/01_not_styled.php) to [02](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/02_basically_styled.php)

* first of all, I aligned the indention everywhere, one tab is converted into four spaces
* than, I added common style guide to this 
    * "{" on the next line by classes
    * "{" after each "if" and "else"
    * content of "if" or "else" on the next line
* afterwards, I moved and grouped the properties and the methods by its visibility (public, protected, private)
* the next step was to provide valid php documentation blocks above each property or method

### From [02](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/02_basically_styled.php) to [03](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/03_styled.php)

* if possible (meaning when not breaking the public API), I renamed properties or methods by having "explain what they are doing" in mind
* I removed early returns and made sure than always something is returned if at least one thing was returned in the past
* removed duplicated code by creating fitting methods
* added helper methods to easy up code reading
* added variables to easy up code reading

### From [03](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/03_styled.php) to [04](https://github.com/stevleibelt/refactoring/blob/master/style/php/01/04_refactored.php)

* first of all, the data object should just contain the data (class Mail)
* what should be done has to be in its own class (class MailDispatcher)
* I remove the complexity and the magic of "trying to fix an email address" in the Mail class
* I made the behaviour of the Mail class consistent by letting it throw exceptions when invalid arguments are provided
* this is also true for the MailDispatcher
