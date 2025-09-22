Sub VBFN_004()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, bp_leakage_value, fp_leakage_value

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    bp_leakage_value = HmiRuntime.SmartTags("ISG_ACTUAL_VALUE_AI_1")
    fp_leakage_value = HmiRuntime.SmartTags("ISG_ACTUAL_VALUE_AI_2")

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_icf_02 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_icf_02 SET " & _
                   "bp_leakage_value='" & bp_leakage_value & "'," & _
                   "fp_leakage_value='" & fp_leakage_value & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_icf_02 (" & _
                   "id, bp_leakage_value, fp_leakage_value" & _
                   ") VALUES (" & _
                   test_id & ",'" & bp_leakage_value & "','" & fp_leakage_value & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "VBFN_004 Error: " & Err.Description
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