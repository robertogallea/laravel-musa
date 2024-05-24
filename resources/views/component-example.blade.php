<html>
<head>
    <title>Test components</title>
</head>
<body>
<h1>Test components</h1>

<x-test-component type="test" value="2" :number-of-iterations="$numberOfIterations" style="background-color: lime" class="danger" abc="123">
    Ciao come ti chiami?
    <ul>
        <li>A</li>
        <li>B</li>
        <li>C</li>
    </ul>
    <x-slot:title>
        Titolo del componente
    </x-slot:title>
</x-test-component>

<x-test-component/>

<x-test-component>
<!-- ciao -->
</x-test-component>

<x-view-only-component/>

<x-inline-component text="Componente inline"/>

<x-dynamic-component :component="$componentName" />
</body>
</html>
