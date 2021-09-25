<html>
    <body>
        <!-- div php-if="$foo">
            bara
            <div php-if="$foo">
                bam
            </div>
            <div php-else></div>
            <input type="text" php-is:disabled="$foo === $bar">sss</input>
        </div -->
        <!-- slot name="slot1"></slot>
        <slot name="slot-array"></slot>
        <slot name="slot-0"></slot>
        <slot name="slot-0-default">
            <div>This is slot default</div>
        </slot>
        slot-nested
        <slot name="slot-nested"></slot>
        slot-array-nested
        <slot name="slot-array-nested"></slot>
        
        <component src="component-1"></component>
        <component src="components/component"></component>
        <component src="components/component-slot">
            <component src="components/component-slot2">123</component>
        </component -->
        <component src="components/component-slot" data="['foo' => $bar]">
            This component has scoped data
            <component src="components/component"></component>
        </component>
        <component src="components/component-slot" data="['foo' => [1,2,3]]">
            This component has scoped data
            <component src="components/component-slot" data="['bar' = $foo[0]]">
                This one has data too
            </component>
        </component>
        <!--component src="components/component-slot" data="['foo' => [1,2,3]]">
            This component has scoped data and subcomponent loop
            <component src="components/component-slot" php-for="$foo as $bar">{{ $bar }}</component>
            <component src="components/component-slot" php-for="$foo as $bar" data"['bar' => $bar]">{{ $bar }}</component>
        </component -->
    </body>
</html>