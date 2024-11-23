<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>P
            </th>
            <th>
                yyyyMMdd</th>
            <th>
                Debit Account No.</th>
            <th>
                Total Records</th>
            <th> Total Amount</th>
            <th></th>
            <th>
                {{-- *) <span style="font-weight: bold; display: inline;">BOLD</span>  is mandatory --}}
            </th>

        </tr>
    </thead>

    <tbody>
        <tr>
            <td>P</td>
            <td>'{{ str_replace('-', '', $perhitungan_gaji->tanggal_awal) }}</td>
            <td>'1390088880046</td>
            <td>{{ $perhitungan_gaji->detail_gajikaryawan->count() }}</td>
            <td>{{ $perhitungan_gaji->grand_total }}</td>
            <td></td>
        </tr>
    </tbody>

    <thead>
        <tr>

        </tr>
    </thead>

    <thead>
        <tr>
            <th> To Acc No.</th>

            <th>To
                Acc Name</th>

            <th>To
                Acc Address 1</th>

            <th>To
                Acc Address 2</th>

            <th>To
                Acc Address 3</th>

            <th>
                Transfer Currency
            </th>

            <th>
                Transfer Amount
            </th>
            <th>
                Transaction Remark
            </th>

            <th>
                Customer Ref No.
            </th>

            <th>
                FT Service</th>
            <th> To Acc Bank Code</th>

            <th>
                To Acc Bank Name</th>

            <th>
                To Acc Bank Address 1</th>

            <th>
                To Acc Bank Address 2</th>

            <th>
                To Acc Bank Address 3</th>

            <th>
                Bank City Name / Country Name</th>

            <th>
                Beneficiary Notification Flag</th>

            <th>
                Benef Notification E-mail</th>

            <th>
                Organization Directory Name</th>

            <th>
                Identical Status</th>

            <th>
                Beneficiary Status</th>

            <th>
                Beneficiary Citizenship</th>

            <th>
                Purpose of Transaction</th>

            <th>
                Remittance Code 1</th>

            <th>
                Remittance Information 1</th>

            <th>
                Remittance Code 2</th>

            <th>
                Remittance Information 2</th>

            <th>
                Remittance Code 3</th>

            <th>
                Remittance Information 3</th>

            <th>
                Remittance Code 4</th>

            <th>
                Remittance Information 4</th>

            <th>
                Instruction Code 1</th>

            <th>
                Instruction Remark 1</th>

            <th>
                Instruction Code 2</th>

            <th>
                Instruction Remark 2</th>

            <th>
                Instruction Code 3</th>

            <th>
                Instruction Remark 3</th>

            <th>
                Charge Instruction</th>

            <th>
                SWIFT Method / Beneficiary Type</th>

            <th>
                Extended Payment Detail</th>

            <th>
                Special Rate Ref No</th>

            <th>
                Underlying Document Code</th>

            <th>
                Sender to Receiver Information Code 2</th>

            <th>
                Sender to Receiver Information Line 2</th>

            <th>
                Sender to Receiver Information Code 3</th>

            <th>
                Sender to Receiver Information Line 3</th>

            <th>
                Sender to Receiver Information Code 4</th>

            <th>
                Sender to Receiver Information Code 5</th>

            <th>
                Sender to Receiver Information Line 5</th>

            <th>
                Sender to Receiver Information Code 6</th>

            <th>
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
                <td>{{ $detail->karyawan->gmail ?? null }}
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
