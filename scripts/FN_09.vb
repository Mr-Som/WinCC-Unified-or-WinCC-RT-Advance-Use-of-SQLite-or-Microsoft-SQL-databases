Sub FN_08()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, observe_value, reord_value, percent_value, defects, action, iop_wagons

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    observe_value = HmiRuntime.SmartTags("TBL07_OBSERVE_VALUE")
    reord_value = HmiRuntime.SmartTags("TBL07_REORD_VALUE")
    percent_value = HmiRuntime.SmartTags("TBL07_PERCENT_VALUE")
    defects = HmiRuntime.SmartTags("TBL07_DEFECTS")
    action = HmiRuntime.SmartTags("TBL07_ACTION")
    iop_wagons = HmiRuntime.SmartTags("TBL07_IOP_WAGONS")

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_07 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists -> UPDATE
        sqlQuery = "UPDATE tbl_07 SET " & _
                   "observe_value='" & observe_value & "'," & _
                   "reord_value='" & reord_value & "'," & _
                   "percent_value='" & percent_value & "'," & _
                   "defects='" & defects & "'," & _
                   "action='" & action & "'," & _
                   "iop_wagons='" & iop_wagons & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists -> INSERT
        sqlQuery = "INSERT INTO tbl_07 (" & _
                   "id, observe_value, reord_value, percent_value, defects, action, iop_wagons" & _
                   ") VALUES (" & _
                   test_id & ",'" & observe_value & "','" & reord_value & "','" & percent_value & "','" & defects & "','" & action & "','" & iop_wagons & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_08 Error: " & Err.Description
        timeStamp = Now

        ' Log error in text file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub
