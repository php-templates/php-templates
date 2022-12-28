    <div class="table-wrapper">
        <table>
            <thead>
                <th p-foreach="$headings as $heading">{{ $heading }}</th>
                <th p-if="$this->slots('action')">Action</th>
            </thead>
            <tbody>
                <tr p-foreach="$data as $i => $item">
                    <td p-foreach="$headings as $k => $v">{{ $item[$k] }}</td>
                    <slot name="action" :id="$item['id']" :i="$i"></slot>
                </tr>
            </tbody>
        </table>
    </div>