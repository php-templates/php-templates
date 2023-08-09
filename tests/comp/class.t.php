<div>
    {!! $comp !!}
</div>

<?php return new class
{
    protected array $props = [
        'name' => 'Phpt'
    ];
    
    public function data($data): array
    {
        $data['age'] = 30;
        $data['class'] = 'yeee';
        $data['comp'] = $GLOBALS['VIEW']->fromPath('comp/3', $data);
        
        return $data;
    }
}; 
?>