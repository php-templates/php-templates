    <div class="table-wrapper">
        <table>
            <thead>
                <th p-foreach="$headings as $heading">{{ $heading }}</th>
                <th p-if="$this->slots('action')">Action</th>
            </thead>
            <tbody>
                <tr p-foreach="$data as $i => $_data">
                    <td p-foreach="$headings as $k => $v">{{ $_data[$k] }}</td>
                    <slot name="action" :id="$_data['id']" :i="$i"></slot>
                </tr>
            </tbody>
        </table>
    </div>