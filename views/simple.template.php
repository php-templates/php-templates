<html>
    <body>
        <div php-if="$foo">
            bara
            <div php-if="$foo">
                bam
            </div>
            <div php-else></div>
            <input type="text" php-is:disabled="$foo === $bar">sss</input>
        </div>
    </body>
</html>