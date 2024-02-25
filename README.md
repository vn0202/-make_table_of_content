# Make Table Of Content. 
Create a Table Of Content  from H1->H6 tag in HTML string 

This package provide a simple way to build a Table-Of-Contents from HTML markups. 
Assume you are create post or article, this package provide you a generator that help you build a Table Of Content automatically. 

## Usage 

This package have one class with 2 method:
  - One for make menu( return under array ).
  - Other for generate HTML Table Of Content from above menu. 

Assume you have post content() stored in database. You can retrieve database to get 
post's content and assign it to $html like this : 

```php 
$contents = <<<EOF 
<h1 id="heading-1">This is heading 1</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, sunt.</p>
<h2 id="heading-2">This is heading 2</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam consequuntur eius eveniet fuga illo iure modi,</p>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi cumque ducimus iste possimus veniam! Animi
    cupiditate fugiat molestiae tenetur vel?</p>
<h3 id="heading-3">This is heading 3</h3>
<h3 id="heading-3-1">This is heading 3</h3>
<h4 id="heading-4">This is heading 4</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ad eos harum inventore ipsum laboriosam quaerat ratione,
</p>
<h4 id="heading-4-1">This is heading 4</h4>
<h2 id="heading-2-1">This is heading 2</h2>
<h2 id="heading-2-2">This is heading 2</h2>
EOF;

```

Then you can use GenerateToc to make menu: 

```php 
use Vannghia\MakeTableOfContent\GenerateTOC;
$htmlTable = GenerateTOC::generateTableFromContent($contents);
dd($contents) // you will get String of HTML of Table Of Content. 

```
 Result will be : 
```html

<ul>
    <li><a href='#heading-1'>This is heading 1
        <ul>
            <li><a href='#heading-2'>This is heading 2
                <ul>
                    <li><a href='#heading-3'>This is heading 3</a></li>
                    <li><a href='#heading-3-1'>This is heading 3
                        <ul>
                            <li><a href='#heading-4'>This is heading 4</a></li>
                            <li><a href='#heading-4-1'>This is heading 4</a></li>
                        </ul>
                    </a></li>
                    <li><a href='#heading-2-1'>This is heading 2</a></li>
                    <li><a href='#heading-2-2'>This is heading 2</a></li>
                </ul>
            </a></li>
        </ul>
    </a></li>
</ul>
```
In blade, You can use like this : 

```php
<div>

    @php 
    if(!empty($contents))
    $tableOfContent = GenerateTOC::generateTableFromContent($contents) ?: [];
    @endphp
    @if($tableOfContent)
           {!! $tableOfContent !!}
    @endif
</div>
```




