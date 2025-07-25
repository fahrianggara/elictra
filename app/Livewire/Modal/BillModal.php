<?php

namespace App\Livewire\Modal;

use App\Models\Bill;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class BillModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $bill_id;
    public $customer_id = '';
    public $period;
    public $meter_start;
    public $meter_end;
    public $status;
    public $due_date;
    public $customers = [];
    public $customerInfo;
    public $total_meter;
    public $total_bill;
    public $invoice;

    /**
     * Mount the component with the given customers.
     *
     * @param  mixed $customers
     * @return void
     */
    public function mount($customers)
    {
        $this->customers = $customers;
    }

    /**
     * Update the component when a property changes.
     *
     * @param  mixed $property
     * @return void
     */
    public function updated($property, $value)
    {
        if ($property == 'customer_id') {
            // jika ada sebelumnya tidak ada data bill,  ambil initial meter dari customer
            $customer = Customer::findOrFail($this->customer_id);
            $this->customerInfo = $customer;

            $billLast = $this->customerInfo->bills()->latest()->first();
            $this->meter_start = $billLast ? $billLast->meter_end : $this->customerInfo->initial_meter;
            $this->period = $billLast ? null : now()->format('Y-m');
            $this->invoice = Random::generate(15, '0-9A-Z');

            $this->resetErrorBag(['customer_id', 'meter_start']);
            if (!$billLast) $this->resetErrorBag('period');
        }

        if ($property == 'meter_end') {
            $this->resetErrorBag('meter_end');

            if (!empty($this->meter_end) && $this->meter_end <= $this->meter_start) {
                $this->addError('meter_end', 'Meteran bulan ini harus lebih besar dari meteran bulan lalu.');
                return;
            }
        }

        if ($property == 'period') {
            $this->resetErrorBag('period');

            // jika sudah ada periode yg buat sebelumnya, tidak boleh dipakai lagi
            if (Bill::query()->where('customer_id', $this->customer_id)->where('period', $this->period)->exists()) {
                $periodFormatted = formatPeriod($this->period);
                $this->addError('period', "Periode {$periodFormatted} sudah ada tagihan sebelumnya.");
                $this->due_date = null;
                $this->period = null;
                return;
            }

            if (!empty($this->meter_end) && $this->meter_end <= $this->meter_start) {
                $this->addError('meter_end', 'Meteran bulan ini harus lebih besar dari meteran bulan lalu.');
                return;
            }

            // automatis set due date 28 hari setelah periode
            $this->due_date = Carbon::parse($this->period)->day(24)->addMonth()->format('Y-m-d');
        }

        if (!empty($this->meter_end) && !empty($this->period)) {
            $this->total_meter = $this->meter_end - $this->meter_start;
            $rate = $this->customerInfo->tarif->price_per_kwh ?? 0;
            $this->total_bill = $this->total_meter * $rate;
            $this->resetErrorBag('meter_end');
        }
    }

    /**
     * Render the view for the bill modal.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.bill-modal');
    }

    /**
     * Create a new bill.
     *
     * @return void
     */
    #[On('bill:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store the bill data.
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        if ($this->meter_end <= $this->meter_start) {
            $this->addError('meter_end', 'Meteran bulan ini harus lebih besar dari meteran bulan lalu.');
            return;
        }

        Bill::create([
            'customer_id' => $this->customer_id,
            'period' => $this->period,
            'meter_start' => $this->meter_start,
            'meter_end' => $this->meter_end,
            'due_date' => $this->due_date
                ? Carbon::parse($this->due_date)
                : Carbon::parse($this->period)->startOfMonth()->addDays(28),
            'status' => 'unpaid',
            'invoice' => $this->invoice,
        ]);

        $this->close();
        $this->dispatch('bill:success');
        $this->dispatch('toast', icon: 'success', message: 'Tagihan berhasil dibuat.');
    }

    /**
     * Close the bill modal.
     *
     * @return void
     */
    public function close()
    {
        $this->dispatch('modal:hide');
    }

    /**
     * Close the modal and reset all fields.
     *
     * @return void
     */
    #[On('modal:onreset')]
    public function onreset()
    {
        $this->reset([
            'deleting',
            'editing',
            'bill_id',
            'customer_id',
            'meter_start',
            'meter_end',
            'status',
            'due_date',
            'period',
            'customerInfo',
            'total_meter',
            'total_bill',
            'invoice',
        ]);

        $this->resetErrorBag();
    }

    /**
     * rules
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'period' => 'required|date_format:Y-m',
            'meter_start' => 'required|numeric|min:0',
            'meter_end' => 'required|numeric|min:0',
            'due_date' => 'nullable|date|after_or_equal:today',
            'invoice' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bills')->where(function ($query) {
                    return $query->where('customer_id', $this->customer_id)
                        ->where('period', $this->period);
                })->ignore($this->bill_id, 'id'),
            ],
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    protected function messages()
    {
        return [
            'customer_id.required'         => 'Pelanggan harus dipilih.',
            'customer_id.exists'           => 'Pelanggan tidak ditemukan.',
            'period.required'              => 'Periode wajib diisi.',
            'period.date_format'           => 'Format periode harus YYYY-MM.',
            'meter_start.required'         => 'Meteran bulan lalu wajib diisi.',
            'meter_start.numeric'          => 'Meteran bulan lalu harus berupa angka.',
            'meter_start.min'              => 'Meteran bulan lalu minimal 0.',
            'meter_end.required'           => 'Meteran bulan ini wajib diisi.',
            'meter_end.numeric'            => 'Meteran bulan ini harus berupa angka.',
            'meter_end.min'                => 'Meteran bulan ini minimal 0.',
            'due_date.date'                => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
            'due_date.after_or_equal'      => 'Tanggal jatuh tempo tidak boleh kurang dari hari ini.',
            'invoice.required'             => 'Nomor invoice wajib diisi.',
            'invoice.string'               => 'Nomor invoice harus berupa string.',
            'invoice.max'                  => 'Nomor invoice maksimal :max karakter.',
            'invoice.unique'               => 'Nomor invoice sudah digunakan untuk tagihan pada periode yang sama.',
        ];
    }
}
