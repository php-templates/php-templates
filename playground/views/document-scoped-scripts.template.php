<html>
    <body>
        <template is="components/component-with-script"></template>
        <template is="components/component-with-script"></template>
        <script p-foreach="$scripts as $script">{{$script}}</script>
    </body>
</html>