Sub FN_000()
Const DB_PATH = "C:\Users\RUPA BANERJEE\Desktop\ReportViewer_v1.0.0.50\Data\database\rtr.db"
Const LOG_PATH = "C:\Users\RUPA BANERJEE\Desktop\ReportViewer_v1.0.0.50\Data\database\error_logs.txt"

HmiRuntime.SmartTags("DB_PATH") = DB_PATH
HmiRuntime.SmartTags("LOG_PATH") = LOG_PATH
End Sub