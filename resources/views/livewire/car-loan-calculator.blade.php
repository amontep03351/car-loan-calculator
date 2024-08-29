<div class="container mt-5">
    <h2>เครื่องคำนวณการผ่อนรถ</h2>
    <form wire:submit.prevent="calculate">
        <div class="form-group">
            <label for="loan-amount">จำนวนเงินกู้:</label>
            <input type="text" class="form-control" id="loan-amount" wire:model.defer="loanAmount" required>
        </div>
        <div class="form-group">
            <label for="interest-rate">อัตราดอกเบี้ย (ต่อปี %):</label>
            <input type="number" step="0.01" class="form-control" id="interest-rate" wire:model.defer="interestRate" required>
        </div>
        <div class="form-group">
            <label for="installments">จำนวนงวด:</label>
            <select class="form-control" id="installments" wire:model.defer="installments" required>
                <option value="12">12 เดือน</option>
                <option value="36">36 เดือน</option>
                <option value="84">84 เดือน</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            คำนวณ
            <span wire:loading wire:target="calculate" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
          <!-- แสดงปุ่มล้างข้อมูลเฉพาะเมื่อมีตารางข้อมูล -->
          @if(!empty($paymentSchedule))
            <button type="button" class="btn btn-secondary" wire:click="clear">ล้างข้อมูล</button>
        @endif
    </form>

    @if(!empty($paymentSchedule)) 
        <div id="result" class="mt-4">
            <h3>ตารางการชำระเงิน</h3>
            <table class="table table-hover table-bordered table-light">
                <thead>
                    <tr>
                        <th>งวด</th>
                        <th>เงินต้น</th>
                        <th>ดอกเบี้ย</th>
                        <th>การชำระเงินรวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sumPrincipal = 0;
                        $sumInterest = 0;
                        $sumTotal = 0;
                    @endphp
                    @foreach($paymentSchedule as $payment)
                        @php
                            $principal = floatval($payment['principal']);
                            $interest = floatval($payment['interest']);
                            $total = floatval($payment['total']);
                        @endphp
                        <tr class="{{ $total > 5000 ? 'bg-danger text-white' : '' }}">
                            <td>{{ $payment['installment'] }}</td>
                            <td>{{ number_format($principal, 2) }}</td>
                            <td>{{ number_format($interest, 2) }}</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                        @php
                            $sumPrincipal += $principal;
                            $sumInterest += $interest;
                            $sumTotal += $total;
                        @endphp
                    @endforeach
                    <!-- แถวรวม -->
                    <tr class="font-weight-bold">
                        <td>รวม</td>
                        <td>{{ number_format($sumPrincipal, 2) }}</td>
                        <td>{{ number_format($sumInterest, 2) }}</td>
                        <td>{{ number_format($sumTotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // ตรวจสอบการกรอกข้อมูลในช่อง "จำนวนเงินกู้"
        $('#loan-amount').on('input', function() {
            var value = $(this).val();
            if (!$.isNumeric(value)) {
                // ถ้าไม่ใช่ตัวเลข
                $(this).val(''); // เคลียร์ช่อง
                alert('กรุณากรอกตัวเลขเท่านั้น'); // แสดงข้อความเตือน
            }
        });
    });
</script>