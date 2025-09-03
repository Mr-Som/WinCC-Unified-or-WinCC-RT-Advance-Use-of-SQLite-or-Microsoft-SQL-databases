Sub FN_012()

    On Error Resume Next

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, bp_leakage_value, fp_leakage_value

    ' Get DB and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get test ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Read tag values
    bp_leakage_value = HmiRuntime.SmartTags("BC2_V")
    fp_leakage_value = HmiRuntime.SmartTags("FP2_V")

    ' Open DB Connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if record exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_10 WHERE id=" & test_id
    Set objRS = objConn.Execute(checkQuery)

    ' Insert or Update based on record availability
    If objRS("cnt") > 0 Then
        sqlQuery = "UPDATE tbl_lhb_10 SET " & _
                   "bp_leakage_value=" & bp_leakage_value & ", " & _
                   "fp_leakage_value=" & fp_leakage_value & " " & _
                   "WHERE id=" & test_id
    Else
        sqlQuery = "INSERT INTO tbl_lhb_10 (id, bp_leakage_value, fp_leakage_value) VALUES (" & _
                   test_id & "," & bp_leakage_value & "," & fp_leakage_value & ")"
    End If

    ' Execute query
    objConn.Execute sqlQuery

    ' Error handling and log writing
    If Err.Number <> 0 Then
        strError = "Error in FN_012: " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close objects
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub
