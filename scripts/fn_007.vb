Sub FN_007()

    On Error Resume Next

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, bp_pressure, fp_pressure

    ' Get DB and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Fetch ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Get numeric values
    bp_pressure = HmiRuntime.SmartTags("OS_BP_VALUE")
    fp_pressure = HmiRuntime.SmartTags("OS_FP_VALUE")

    ' Open DB Connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if record exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_05 WHERE id=" & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        sqlQuery = "UPDATE tbl_lhb_05 SET " & _
                   "bp_pressure=" & bp_pressure & ", " & _
                   "Fp_pressure=" & fp_pressure & " " & _
                   "WHERE id=" & test_id
    Else
        sqlQuery = "INSERT INTO tbl_lhb_05 (id, bp_pressure, Fp_pressure) VALUES (" & _
                   test_id & "," & bp_pressure & "," & fp_pressure & ")"
    End If

    objConn.Execute sqlQuery

    ' Error Handling
    If Err.Number <> 0 Then
        strError = "Error in FN_007: " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub
