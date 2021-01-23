<div>
        <!-- List Table -->
        <table class="table table-striped">
            <!-- Table Header -->
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Product Packing</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Coupon Used</th>
                    <th>Discounted Amount</th>
                </tr>
            </thead>
            <!-- Table Header -->
            <!-- Table Body -->
            <tbody>
                <!-- Table Row Repeat -->
                @foreach ($collection as $item)
                    
                @endforeach
                <tr>
                    <td>1</td>
                    <td>132</td>
                    <td class="numOf">Afghan Hash</td>
                    <td>Sativa</td>
                    <td>30g</td>
                    <td>10</td>
                    <td>$100</td>
                    <td class="txt-caps">Monsoon</td>
                    <td>$10</td>
                </tr>
                <!-- Table Row Repeat -->
            </tbody>
        </table>
        <!-- List Table -->

    </div>