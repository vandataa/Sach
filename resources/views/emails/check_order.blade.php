<div style="width:600px; margin: 0 auto">
<div style="text-align: center;">
<h2>Xin chào {{$auth->name}}</h2>
<p>Đơn hàng của bạn đã được xác nhận, bạn vui lòng xem qua đơn hàng!</p>
</div>
<div>
    <h3 style="text-align:center">Thông tin người đặt</h3>

    <table border="1" cellspacing="0" cellpadding="10" style="width:100%">
        <thead>
            <tr>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Trạng thái đơn hàng</th>
                <th>Ghi chú</th>
                <th>Thời gian đặt hàng</th>
            </tr>
        </thead>
            <tbody>
                <tr>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ number_format( $order->total, 0, ',', '.') }} VNĐ</td>
                    <td>
                        {{$order->status}}
                    </td>
                    <td>{{ $order->note }}</td>
                    @php
                        $date = new DateTime(); // Thay thế đoạn này bằng đối tượng DateTime thực tế của bạn
                        $order->date = $date->format('Y-m-d H:i:s'); // Chuyển đổi đối tượng DateTime thành chuỗi
                        $date = htmlspecialchars($order->date);
                    @endphp
                    <td>{{ $date }}</td>
                </tr>

            </tbody>
        
    </table>
    <br>
    <hr>
        <h3 style="text-align:center">
    Chi tiết đơn hàng
        </h3>
        <table  border="1" cellspacing="0" cellpadding="10" style="width:100%">
            <thead>
                <tr class="title-top">
                    <td>STT</td>
                    <td>Tên Sách</td>
                    <td>Số Lượng</td>
                    <td>Giá Sách</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_details as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->title_book }}</td>
                        <td>{{ $item->book_quantity }}</td>
                        <td>{{ number_format( $item->price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>