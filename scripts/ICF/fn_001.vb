Sub FN_001()

    On Error Resume Next  ' Enable error handling

    Dim train_no, train_name, date_of_testing, washing_pit_no, shift, sse
    Dim operator_name, pipe_type, rake_type, load, coach_type
    Dim objconn, commandtext
    Dim strError, dbPath, logFile, fso, file
    Dim timeStamp

    ' Path to SQLite database (make sure it's accessible by WinCC RT)
    dbPath = "C:\xampp\htdocs\database\rtr.db"  ' Change to your actual path

    ' Create connection object
    Set objconn = CreateObject("ADODB.Connection")

    ' DSN-less SQLite ODBC connection string
    objconn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Read values from HMI SmartTags
    train_no = HmiRuntime.SmartTags("NEW_RTR_TRAIN_NO")
    train_name = HmiRuntime.SmartTags("NEW_RTR_TRAIN_NAME")
    date_of_testing = HmiRuntime.SmartTags("NEW_RTR_DATE_OF_TESTING")
    washing_pit_no = HmiRuntime.SmartTags("NEW_RTR_WASHING_PIT_NO")
    Select Case HmiRuntime.SmartTags("NEW_RTR_SHIFT")
    Case 0
        shift = "Nothing Selected"
    Case 1
        shift = "Shift A"
    Case 2
        shift = "Shift B"
    Case Else
        shift = "Shift C"
    End Select
    sse = HmiRuntime.SmartTags("NEW_RTR_SSE")
    operator_name = HmiRuntime.SmartTags("NEW_RTR_OPERATOR_NAME")
    Select Case HmiRuntime.SmartTags("NEW_RTR_PIPE_TYPE")
    Case 0
        pipe_type = "Nothing Selected"
    Case 1
        pipe_type = "Single Pipe"
    Case Else
        pipe_type = "Twin Pipe"
    End Select
    rake_type = HmiRuntime.SmartTags("NEW_RTR_RAKE_TYPE")
    load = HmiRuntime.SmartTags("NEW_RTR_LOAD")
    If HmiRuntime.SmartTags("NEW_RTR_COACH_TYPE") = 0 Then
        coach_type = "LHB"
    Else
        coach_type = "ICF"
    End If


    ' Build SQL INSERT query
    commandtext = "INSERT INTO train_maintenance_report " & _
                  "(train_no, train_name, date_of_testing, washing_pit_no, shift, sse, operator_name, pipe_type, rake_type, load, coach_type) " & _
                  "VALUES ('" & train_no & "','" & train_name & "','" & date_of_testing & "','" & washing_pit_no & "','" & shift & "','" & sse & "','" & operator_name & "','" & pipe_type & "','" & rake_type & "','" & load & "','" & coach_type & "')"

    ' Execute SQL
    objconn.Execute commandtext

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_001 Error: " & Err.Description
        timeStamp = Now

        ' Log error to text file
        logFile = "C:\xampp\htdocs\database\error_logs.txt" ' Path for error log file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True) ' 8 = Append mode
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If


    ' Close and clean up
    objconn.Close
    Set objconn = Nothing

End Sub