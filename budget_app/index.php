<?php
header("Content-Type: text/html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>💰 Budget App API - Index</title>
</head>
<body>

    <h1>💰 Budget App API Index</h1>
    <p style="text-align:center;">All available API endpoints for your Budget Management system.</p>

    <!-- USER APIs -->
    <div class="api-section">
        <h2>👤 User APIs</h2>
        <ul>
            <li><span class="method">POST</span> <a href="SignUp.php">SignUp.php</a> - Register new user</li>
            <li><span class="method">POST</span> <a href="Login.php">Login.php</a> - User login</li>
            <li><span class="method">GET</span> <a href="Profile.php">Profile.php</a> - View user profile</li>
            <li><span class="method">POST</span> <a href="ProfileUpdate.php">ProfileUpdate.php</a> - Update profile</li>
            <li><span class="method">POST</span> <a href="DeleteProfile.php">DeleteProfile.php</a> - Delete profile</li>
            <li><span class="method">POST</span> <a href="ChangePassword.php">ChangePassword.php</a> - Change password</li>
        </ul>
    </div>

    <!-- ACCOUNT APIs -->
    <div class="api-section">
        <h2>🏦 Account APIs</h2>
        <ul>
            <li><span class="method">POST</span> <a href="AddAccount.php">AddAccount.php</a> - Add new account</li>
            <li><span class="method">GET</span> <a href="ViewAccounts.php">ViewAccounts.php</a> - View all accounts</li>
            <li><span class="method">POST</span> <a href="UpdateAccount.php">UpdateAccount.php</a> - Update account</li>
            <li><span class="method">POST</span> <a href="DeleteAccount.php">DeleteAccount.php</a> - Delete account</li>
        </ul>
    </div>

    <!-- TRANSACTION APIs -->
    <div class="api-section">
        <h2>💸 Transaction APIs</h2>
        <ul>
            <li><span class="method">POST</span> <a href="AddTransaction.php">AddTransaction.php</a> - Add new transaction</li>
            <li><span class="method">GET</span> <a href="ViewTransactions.php">ViewTransactions.php</a> - View all transactions</li>
            <li><span class="method">POST</span> <a href="UpdateTransaction.php">UpdateTransaction.php</a> - Update transaction</li>
            <li><span class="method">POST</span> <a href="DeleteTransaction.php">DeleteTransaction.php</a> - Delete transaction</li>
        </ul>
    </div>

    <!-- EXPENSE APIs -->
    <div class="api-section">
        <h2>🧾 Expense APIs</h2>
        <ul>
            <li><span class="method">POST</span> <a href="AddExpense.php">AddExpense.php</a> - Add expense</li>
            <li><span class="method">GET</span> <a href="ViewExpenses.php">ViewExpenses.php</a> - View all expenses</li>
            <li><span class="method">GET</span> <a href="ViewExpenseById.php">ViewExpenseById.php</a> - View single expense</li>
            <li><span class="method">POST</span> <a href="UpdateExpense.php">UpdateExpense.php</a> - Update expense</li>
            <li><span class="method">POST</span> <a href="DeleteExpense.php">DeleteExpense.php</a> - Delete expense</li>
        </ul>
    </div>

    <!-- INCOME APIs -->
    <div class="api-section">
        <h2>💰 Income APIs</h2>
        <ul>
            <li><span class="method">POST</span> <a href="AddIncome.php">AddIncome.php</a> - Add income</li>
            <li><span class="method">GET</span> <a href="ViewIncome.php">ViewIncome.php</a> - View all incomes</li>
            <li><span class="method">GET</span> <a href="ViewIncomeById.php">ViewIncomeById.php</a> - View single income</li>
            <li><span class="method">POST</span> <a href="UpdateIncome.php">UpdateIncome.php</a> - Update income</li>
            <li><span class="method">POST</span> <a href="DeleteIncome.php">DeleteIncome.php</a> - Delete income</li>
        </ul>
    </div>

    <!-- REPORT APIs -->
    <div class="api-section">
        <h2>📊 Report APIs</h2>
        <ul>
            <li><span class="method">GET</span> <a href="SummaryReport.php">SummaryReport.php</a> - Overall summary</li>
            <li><span class="method">GET</span> <a href="MonthlySummary.php">MonthlySummary.php</a> - Monthly report</li>
            <li><span class="method">GET</span> <a href="SixMonthSummary.php">SixMonthSummary.php</a> - 6-month report</li>
            <li><span class="method">GET</span> <a href="YearlySummary.php">YearlySummary.php</a> - Yearly report</li>
        </ul>
    </div>
</body>
</html>
