# Implementation Verification – Profit & Withdrawal

## 1. Settings → Monthly profit %

| Step | Implementation | Status |
|------|----------------|--------|
| Admin sets percentage | Settings page: "نسبة الربح الشهرية %" saved to `monthly_profit_rates` (year_month, percentage) | OK |
| Stored per month | `updateOrCreate(['year_month' => $yearMonth], ['percentage' => ...])` | OK |
| Clear rate | If field is empty on save, row for current month is **deleted** so calculation uses legacy logic | **Fixed** |

**Flow:** `UsersController::getSetting()` loads current month rate; `updateSetting()` saves or deletes it. Table: `monthly_profit_rates`.

---

## 2. Profit calculation (command)

| Rule | Implementation | Status |
|------|----------------|--------|
| Use monthly % when set | `MonthlyProfitRate::where('year_month', $yearMonth)->first()`; if exists and percentage > 0, use it | OK |
| Formula | **Profit = Investment (cash) × (percentage / 100)** | OK |
| Apply to active investors | `User::where('enabled', 1)->where('cash', '>', 0)->whereDate('expire_contract', '>', now())` + excluded IDs from config | OK |
| No duplicate per user per month | Skip if `profit_ratio_log` already has same user + same month (by `year_month` **or** by `created_at` month when `year_month` is null) | **Fixed** |
| Legacy when no rate | If no monthly rate or percentage = 0, falls back to ratio-based logic (profit_release_day, expire, etc.) | OK |
| Log has month | Each new record has `year_month` (e.g. 2026-02) | OK |
| Status | New records created with `status = 0` (pending); admin approves from Profit list | OK |

**Command:** `php artisan app:profit-calculation`  
**Trigger in admin:** Profit list → button "أطلاق الارباح" → `profit-check.release` → runs the command.

---

## 3. Admin profit approval

| Step | Implementation | Status |
|------|----------------|--------|
| List | Profit list with filters (investor, date, status) | OK |
| Approve | `ProfitController::approve()`: set log status = 1, increment user `profit` and `total_profit`, create transaction | OK |

---

## 4. Withdraw (API – api_ajayal)

| Rule | Implementation | Status |
|------|----------------|--------|
| Min amount | 150 USD or 150,000 IQD by user currency | OK |
| Last 5 days of month | Reject if `day < (lastDay - 4)` | OK |
| One per month | Reject if user already has pending/approved withdraw in current month | OK |
| New request = Pending | Create with `status = 0` | OK |

---

## 5. Withdraw (Admin panel)

| Rule | Implementation | Status |
|------|----------------|--------|
| List + filters | Pending / Approved / Rejected, dates, investor | OK |
| Approve | Deduct from user profit, set status = 1 | OK |
| Reject | Set status = 2, optional `reject_reason` | OK |

---

## 6. Website (ajayal-website)

| Rule | Implementation | Status |
|------|----------------|--------|
| Last 5 days message | Show message and disable form when outside window | OK |
| Min amount | Validate and show 150 USD / 150k IQD message | OK |

---

## Fixes applied in this pass

1. **Clear monthly rate:** When admin leaves "نسبة الربح الشهرية %" empty and saves, the current month’s row in `monthly_profit_rates` is **deleted**, so the next profit run uses legacy (ratio) logic instead of an old percentage.
2. **Duplicate profit check:** Duplicate is now detected if there is already a profit log for that user for the same month **either** by `year_month` **or** by `created_at` when `year_month` is null (old data), so we never create two profits for the same user in the same month.

---

## Config to check

- **Excluded user IDs from profit:** `config/app.php` → `exclude_investor_user_ids` (env: `EXCLUDE_INVESTOR_USER_IDS`, default `1`). These users are excluded from profit calculation and from the investor list.

---

## Summary

- **Settings:** Save/load/clear monthly % works; clearing the field removes the rate for the current month.
- **Profit calculation:** Uses monthly % when set (Investment × percentage), no duplicate per user per month (including old rows without `year_month`), legacy ratio used when no rate.
- **Admin profit:** List and approve flow correct.
- **Withdraw (API + admin + website):** Rules and UI as above.

No further logic changes required for the flows above; only deploy the two code fixes (settings clear + duplicate check) to the server.
