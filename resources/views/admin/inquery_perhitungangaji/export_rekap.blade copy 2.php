<table>
    <thead>
        <tr>
            {{-- <th style="font-weight: bold; background-color: yellow; text-align: center; border: 1px solid black;">
                HEADER
            </th> --}}
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;"></th>
            <th style="font-weight: bold;"></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="font-weight: bold; background-color: yellow;">P
            </th>
            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                yyyyMMdd</th>
            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Debit Account No.</th>
            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Total Records</th>
            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Total Amount</th>
            <th></th>
            <th colspan="3">
                {{-- *) <span style="font-weight: bold; display: inline;">BOLD</span>  is mandatory --}}
            </th>

        </tr>
    </thead>

    <tbody>
        <tr>
            <td>P</td>
            <td style="text-align: left">'{{ str_replace('-', '', $perhitungan_gaji->tanggal_awal) }}</td>
            <td style="text-align: left; width: 120px;">'1390088880046</td>
            <td>{{ $perhitungan_gaji->detail_gajikaryawan->count() }}</td>
            <td>{{ $perhitungan_gaji->grand_total }}</td>
            <td></td>
        </tr>
    </tbody>

    <thead>
        <tr>
            {{-- <th style="font-weight: bold; background-color: yellow; text-align:center; border: 1px solid black;">
                CONTENT
            </th> --}}
        </tr>
    </thead>

    <thead>
        <tr>
            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; width: 150px; white-space: normal; word-wrap: break-word;">
                To Acc No.</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">To
                Acc Name</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">To
                Acc Address 1</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">To
                Acc Address 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">To
                Acc Address 3</th>

            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; width: 63px; white-space: normal; word-wrap: break-word;">
                Transfer Currency
            </th>

            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; width: 55px; white-space: normal; word-wrap: break-word;">
                Transfer Amount
            </th>
            <th
                style="background-color: yellow; vertical-align: middle; width: 85px; white-space: normal; word-wrap: break-word;">
                Transaction Remark
            </th>

            <th
                style="background-color: yellow; vertical-align: middle; width: 55px; white-space: normal; word-wrap: break-word;">
                Customer Ref No.
            </th>

            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                FT Service</th>
            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; width: 120px; white-space: normal; word-wrap: break-word;">
                To Acc Bank Code</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                To Acc Bank Name</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                To Acc Bank Address 1</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                To Acc Bank Address 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                To Acc Bank Address 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Bank City Name / Country Name</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Beneficiary Notification Flag</th>

            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Benef Notification E-mail</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Organization Directory Name</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Identical Status</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Beneficiary Status</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Beneficiary Citizenship</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Purpose of Transaction</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Code 1</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Information 1</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Code 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Information 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Code 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Information 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Code 4</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Remittance Information 4</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Instruction Code 1</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Instruction Remark 1</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Instruction Code 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Instruction Remark 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Instruction Code 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Instruction Remark 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Charge Instruction</th>

            <th
                style="font-weight: bold; background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                SWIFT Method / Beneficiary Type</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Extended Payment Detail</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Special Rate Ref No</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Underlying Document Code</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Code 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Line 2</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Code 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Line 3</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Code 4</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Code 5</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Line 5</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Code 6</th>

            <th style="background-color: yellow; vertical-align: middle; white-space: normal; word-wrap: break-word;">
                Sender to Receiver Information Line 6</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($detail_gaji as $index => $detail)
            <tr>
                <td>'{{ $detail->karyawan->norek ?? null }}</td>
                <td>{{ $detail->karyawan->nama_lengkap ?? null }}</td>
                <td>{{ $detail->karyawan->alamat3 ?? null }}</td>
                <td>{{ $detail->karyawan->alamat2 ?? null }}</td>
                <td>{{ $detail->karyawan->alamat ?? null }}</td>
                <td>IDR</td>
                <td>{{ $detail->gaji_bersih }}</td>
                <td>Trf InHouse</td>
                <td></td>
                <td>IBU</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>N</td>
                <td style="color: rgb(67, 198, 250); text-decoration: underline;">{{ $detail->karyawan->gmail ?? null }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>EPD{{ $index + 1 }}</td>
                <td></td>
                @if ($index < 2)
                    <td>//</td>
                    <td>info2</td>
                    <td>//</td>
                    <td>info3</td>
                    <td>//</td>
                    <td>info4</td>
                    <td>//</td>
                    <td>info5</td>
                    <td>//</td>
                    <td>info6</td>
                @endif
            </tr>
        @endforeach
    </tbody>

</table>
