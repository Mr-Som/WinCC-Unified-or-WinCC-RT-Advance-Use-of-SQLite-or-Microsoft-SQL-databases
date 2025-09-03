Sub GET_TEST_ID_RTR()

    On Error Resume Next ' Enable error handling

    Dim objConnection
    Dim objCommand
    Dim objRecordset
    Dim strConnectionString
    Dim strSQL
    Dim test_id
    Dim IngCount
    Dim logFile, fso, file, timeStamp, strError
    Dim dbPath

    ' Path to SQLite database
    dbPath = "C:\xampp\htdocs\database\rtr.db"

    ' DSN-less SQLite ODBC connection string
    strConnectionString = "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    strSQL = "SELECT id FROM train_maintenance_report ORDER BY id DESC LIMIT 1"

    ' Create connection and recordset
    Set objConnection = CreateObject("ADODB.Connection")
    objConnection.Open strConnectionString

    Set objRecordset = CreateObject("ADODB.Recordset")
    Set objCommand = CreateObject("ADODB.Command")

    objCommand.ActiveConnection = objConnection
    objCommand.CommandText = strSQL
    Set objRecordset = objCommand.Execute

    If Err.Number <> 0 Then
        ' Handle DB error
        strError = "DB Error: " & Err.Description
        timeStamp = Now
        logFile = "C:\xampp\htdocs\database\error_logs.txt"
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    Else
        If Not objRecordset.EOF Then
            test_id = objRecordset.Fields("id").Value
            HmiRuntime.SmartTags("NEW_RTR_TEST_ID") = test_id
        End If
    End If

    ' Clean up
    Set objCommand = Nothing
    objConnection.Close
    Set objRecordset = Nothing
    Set objConnection = Nothing

End Sub
