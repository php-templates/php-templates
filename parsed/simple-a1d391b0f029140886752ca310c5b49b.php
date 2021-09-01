<!DOCTYPE html>
<html>
    <body>
        &lt;?php if ($foo) { ; ?&gt;<div php-if="$foo">
            bara
            &lt;?php if ($foo) { ; ?&gt;<div php-if="$foo">
                bam
            </div>&lt;?php } ?&gt;
            &lt;?php else { ; ?&gt;<div php-else>
        </div>&lt;?php } ?&gt;
    </div>&lt;?php } ?&gt;</body>
</html>