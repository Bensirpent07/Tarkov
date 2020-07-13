<script type="text/javascript">
    var selectedFilter = '<?=$filter?>'
</script>
<div id="ammoContainer" class="container">
    <div id="tableHeader" class="row">
        <div class="col">
            <h1 id="header">Ammo Information</h1>
            <p>Below is some information on ammo in Escape from Tarkov. This chart is updated daily. Click any table header to sort in ascending or descending order. Select from the filter to show specific ammo that you're looking for.</p>
            <div id="filtersContainer">
                <span class="label">Filter: </span>
                <select id="filterSelect" class="custom-select-sm custom-select">
                    <option selected="">None</option>
                    <?php
                    foreach($ammoCalibers as $caliber){
                        if($filter == $caliber){
                            $html = "<option selected>$caliber</option>";
                            echo $html;
                        }else{
                            $html = "<option>$caliber</option>";
                            echo $html;
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <table id="ammoTable" class="table table-dark">
            <thead>
            <tr id="tableHeaders">
                <th data-sort="" id="ammo_name" scope="col">Name</th>
                <th data-sort="" id="damage" scope="col">Damage</th>
                <th data-sort="" id="pen" scope="col">Penetration</th>
                <th data-sort="" id="frag" scope="col">Fragmentation Chance</th>
                <th data-sort="" id="ricochet" scope="col">Ricochet Chance</th>
                <th data-sort="" id="speed" scope="col">Bullet Velocity</th>
            </tr>
            </thead>
            <tbody id="ammoTable"></tbody>
        </table>
    </div>
</div>