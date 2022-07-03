@php $this->scopeData['val'] = [1,2]; $this->scopeData['name'] = "myname"; @endphp

<c>
    <slot :val="$this->scopeData['val']" :name="$this->scopeData['name']"></slot>
</c>