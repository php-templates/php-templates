{% $headings = ['id' => 'ID', 'name' => 'Name'] %}
{% $data = [['id' => 67, 'name' => 'Mango'],['id' => 32, 'name' => 'Potatos']] %}

<div class="table-wrapper">
    <table>
        <thead>
            <th p-foreach="$headings as $heading">{{ $heading }}</th>
            <th p-if="$this->slots('action')">Action</th>
        </thead>
        <tbody>
            <tr p-foreach="$data as $i => $item">
                <td p-foreach="$headings as $k => $v">{{ $item[$k] }}</td>
            </tr>
        </tbody>
    </table>
</div>
=====
<div class="table-wrapper">
    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
        </thead>
        <tbody>
            <tr>
                <td>67</td>
                <td>Mango</td>
            </tr>
            <tr>
                <td>32</td>
                <td>Potatos</td>
            </tr>
        </tbody>
    </table>
</div>